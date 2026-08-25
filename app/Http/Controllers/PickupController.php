<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pickup;
use App\Models\Article;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\User;

class PickupController extends Controller
{
    public function create()
    {
        $articles = Article::with('stocks')->orderBy('name')->get()->filter(fn ($a) => $a->stocks->sum('quantity') > 0)->values();
        return view('pickups.create', ['articles' => $articles]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.article_id' => ['nullable', 'exists:articles,id'],
            'items.*.quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $lines = collect($data['items'])->filter(
            fn ($r) => !empty($r['article_id']) && ($r['quantity'] ?? 0) > 0);
        if ($lines->isEmpty())
            return back()->withErrors(['items' => 'Bitte mindestens einen Artikel wählen.']);

        foreach ($lines as $row) {
            $article = Article::findOrFail($row['article_id']);
            $available = $article->stocks->sum('quantity');
            if ($row['quantity'] > $available)
                return back()->withErrors(['items' => "{$article->name} nicht ausreichend auf Lager (verfügbar: {$available})."]);
        }
        $pickup = Pickup::create([
            'user_id' => auth()->id(),
            'status' => 'offen',
            'date' => now(),
        ]);

        foreach ($lines as $row) {
            $pickup->items()->create([
                'article_id' => $row['article_id'],
                'quantity' => $row['quantity'],
            ]);

            $stock = Stock::where('article_id', $row['article_id'])->first();
            if ($stock) { $stock->quantity = $stock->quantity - $row['quantity']; $stock->save(); }

            StockMovement::create([
                'article_id' => $row['article_id'],
                'user_id' => auth()->id(),
                'type' => 'Ausgang',
                'quantity' => $row['quantity'],
                'date' => now(),
            ]);
        }
        return redirect()->route('pickups.create')->with('success', 'Ware zur Abholung vorgemerkt.');
    }

    public function index()
    {
        $pickups = Pickup::with('items.article', 'customer')->where('status', 'offen')
            ->where(function ($query) {
                $query->where('spediteur_id', auth()->id())
                ->orWhereNull('spediteur_id');
            })->get();
        return view('pickups.index', ['pickups' => $pickups]);
    }

    public function confirm(Request $request, Pickup $pickup)
    {
        $data = $request->validate([
            'taken' => ['required', 'array'],
            'taken.*' => ['nullable', 'integer', 'min:0'],
        ]);

        foreach ($pickup->items as $item) {
            $taken = (int) ($data['taken'][$item->id] ?? 0);
            $taken = min($taken, $item->quantity);
            $rest = $item->quantity - $taken;

            if ($rest > 0) {
                $stock = Stock::where('article_id', $item->article_id)->first();
                if ($stock) { $stock->quantity += $rest; $stock->save(); }

                StockMovement::create([
                    'article_id' => $item->article_id,
                    'user_id' => auth()->id(),
                    'type' => 'Eingang',
                    'quantity' => $rest,
                    'date' => now(),
                ]);
            }

            $item->update(['taken_quantity' => $taken]);
        }

        $pickup->update(['status' => 'abgeholt']);
        return redirect()->route('pickups.index')->with('success', 'Ware wurde abgeholt.');
    }

    public function manage()
    {
        $pickups = Pickup::with('items.article', 'spediteur')->latest()->get();
        return view('pickups.manage', ['pickups' => $pickups]);
    }

    public function edit(Pickup $pickup)
    {
        $spediteure =User::where('role', 'spediteur')->orderBy('name')->get();
        return view('pickups.edit', ['pickup' => $pickup, 'spediteure' => $spediteure]);
    }

    public function update(Request $request, Pickup $pickup)
    {
    $data = $request->validate([
        'spediteur_id' => ['nullable', 'exists:users,id'],
    ]);
    $pickup->update([
        'spediteur_id' => $data['spediteur_id'] ?: null]);
        return redirect()->route('pickups.manage')->with('success', 'Abholung erfolgreich aktualisiert.');
    }
}

