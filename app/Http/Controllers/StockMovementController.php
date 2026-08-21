<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\Article;
use App\Models\Stock;
use App\Models\StorageLocation;

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

        // Find or create stock record
        $stock = Stock::where('article_id', $article->id)->first();

        if (!$stock) {
            $location = StorageLocation::first();

            if ($location) {
                $stock = Stock::create([
                    'article_id' => $article->id,
                    'storage_location_id' => $location->id,
                    'quantity' => 0,
                    'date' => now(),
                ]);
            } else {
                return back()->withErrors([
                    'error' => 'Kein Lagerplatz vorhanden. Bitte zuerst einen Lagerplatz anlegen.'
                ]);
            }
        }

        // Check if enough stock for Ausgang
        if ($data['type'] === 'Ausgang' && $stock->quantity < $data['quantity']) {
            return back()->withErrors([
                'error' => "Nicht genügend Bestand für \"{$article->name}\" (verfügbar: {$stock->quantity})."
            ]);
        }

        // Update stock quantity
        if ($data['type'] === 'Eingang') {
            $stock->quantity = $stock->quantity + $data['quantity'];
        } else {
            $stock->quantity = $stock->quantity - $data['quantity'];
        }
        $stock->save();

        // Log the stock movement
        StockMovement::create([
            'article_id' => $article->id,
            'user_id' => auth()->id(),
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'date' => now(),
        ]);

        return redirect()->route('stock-movements.index')
            ->with('success', 'Bestand erfolgreich aktualisiert.');
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
