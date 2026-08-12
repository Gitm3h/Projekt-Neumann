<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Article;
use App\Models\Stock;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('items.article')->latest()->get();
        return view('sales.index', ['sales'=>$sales]);
    }

    public function create()
    {
        $articles = Article::orderBy('name')->get();
        return view('sales.create', ['articles'=>$articles]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required',
        ]);
        $article = Article::findOrFail($data['article_id']);

        $sale =Sale::create([
            'user_id' => auth()->id(),
            'payment_method' => $data['payment_method'],
            'total' => $article->price * $data['quantity'],
            'date' => now(),
        ]);

        $sale->items()->create([
            'article_id' => $article->id,
            'quantity' => $data['quantity'],
            'unit_price' => $article->price,
        ]);

        $stock = Stock::where('article_id', $article->id)->first();
        if ($stock) { $stock->quantity = $stock->quantity - $data['quantity']; }

        return redirect()->route('sales.index');

    }
}
