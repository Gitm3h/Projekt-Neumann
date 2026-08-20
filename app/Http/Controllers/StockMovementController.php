<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\Article;
use App\Models\Stock;

class StockMovementController extends Controller
{
    public function index()
    {
    $movements = StockMovement::with(['article', 'user'])->latest()->get();
    return view('stock-movements.index', ['movements' => $movements]);
    }

    public function create()
    {
    $articles = Article::orderBy('name')->get();
    return view('stock-movements.create', ['articles' => $articles]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'article_id' => ['required', 'exists:articles,id'],
            'type' => ['required', 'in:Eingang,Ausgang'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $article = Article::findOrFail($data['article_id']);
        $stock = Stock::where('article_id', $article->id)->first();

        if ($data['type'] === 'Ausgang')
        {
            $available = $stock ? $stock->quantity : 0;
            if ($data['quantity'] > $available)
            {
                return back()->withErrors(['quantity' => "Nicht genügend Bestand für \"{$article->name}\" (verfügbar: {$available})."]);
            }
        }

        StockMovement::create([
            'article_id' => $article->id,
            'user_id' => auth()->id(),
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'date' => now(),
        ]);

        if ($stock)
        {
           if ($data['type'] === 'Eingang')
           {
               $stock->quantity = $stock->quantity + $data['quantity'];
           }
           else
           {
               $stock->quantity = $stock->quantity - $data['quantity'];
           }
           $stock->save();
        }

        else if ($data['type'] === 'Eingang')
        {
            //
        }

        return redirect()->route('stock-movements.index');
    }

    public function destroy(StockMovement $stockMovement)
    {
        $stockMovement->delete();
        return redirect()->route('stock-movements.index')
        ->with('success', 'Buchung gelöscht.');

    }

    public function deliveries()
    {
        $lieferungen = StockMovement::with(['article', 'user'])
            ->where('type', 'Eingang')->latest()->get();

        return view('stock-movements.deliveries', ['lieferungen' => $lieferungen]);
    }
}
