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
            'items' => ['required', 'array'],
            'items.*.article_id' => ['nullable', 'exists:articles,id'],
            'items.*.quantity' => ['nullable', 'integer', 'min:1'],
            'payment_method' => ['required'],
        ]);

        $lines = collect($data['items'])->filter(function ($row)
        {
            return !empty($row['article_id']) && ($row['quantity'] ?? 0) > 0;
        });

        if ($lines->isEmpty())
        {
            return back()->withErrors(['items' => 'Bitte mindestens einen Artikel wählen.']);
        }

        $total = 0;
        foreach ($lines as $row)
        {
            $article = Article::findOrFail($row['article_id']);
            $total += $article->price * $row['quantity'];
        }

        $sale =Sale::create([
            'user_id' => auth()->id(),
            'payment_method' => $data['payment_method'],
            'total' => $total,
            'date' => now(),
        ]);

        foreach ($lines as $row)
        {
            $article =Article::findOrFail($row['article_id']);


            $sale->items()->create([
                'article_id' => $article->id,
                'quantity' => $row['quantity'],
                'unit_price' => $article->price,
            ]);

            $stock = Stock::where('article_id', $article->id)->first();
            if ($stock) { $stock->quantity = $stock->quantity - $row['quantity'];
            $stock->save();}
        }

        return redirect()->route('sales.index');}
    }
