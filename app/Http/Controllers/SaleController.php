<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Article;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Customer;
class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('items.article')->latest()->get();
        return view('sales.index', ['sales'=>$sales]);
    }

    public function create()
    {
        $articles = Article::with('stocks')->orderBy('name')->get()
            ->filter(fn ($a) => $a->stocks->sum('quantity') > 0)
            ->values();

        $customers = Customer::orderBy('name')->get();
        return view('sales.create', ['articles'=>$articles, 'customers'=>$customers]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.article_id' => ['nullable', 'exists:articles,id'],
            'items.*.quantity' => ['nullable', 'integer', 'min:1'],
            'payment_method' => ['required'],
            'customer_id' => ['required_if:payment_method,Rechnung', 'nullable', 'exists:customers,id'],
        ], [
            'customer_id.required_if' => 'Bei Zahlart Rechnung muss ein Kunde angegeben werden.',
            ]
        );

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

            $available = $article->stocks->sum('quantity');
            if ($row['quantity'] > $available) {
                return back()->withErrors([
                    'items' => "{$article->name} ist nicht ausreichend auf Lager (verfügbar: {$available}, angefordert: {$row['quantity']}).",
                ]);
            }

            $total += $article->price * $row['quantity'];
        }

        $sale =Sale::create([
            'user_id' => auth()->id(),
            'customer_id' => $data['customer_id'] ?? null,
            'payment_method' => $data['payment_method'],
            'total' => $total,
            'date' => now(),
        ]);

        foreach ($lines as $row) {
            $article = Article::findOrFail($row['article_id']);


            $sale->items()->create([
                'article_id' => $article->id,
                'quantity' => $row['quantity'],
                'unit_price' => $article->price,
                'vat_rate' => $article->vat_rate,
            ]);


            $stock = Stock::where('article_id', $article->id)->first();
            if ($stock) {
                $stock->quantity = $stock->quantity - $row['quantity'];
                $stock->save();
            }

            StockMovement::create([
                'article_id' => $article->id,
                'user_id' => auth()->id(),
                'type' => 'Ausgang',
                'quantity' => $row['quantity'],
                'date' => now(),
            ]);
        }

            $customer =$sale->customer;
            $termDays = null;
            $dueDate = null;
            if ($customer && $customer->type === 'gewerblich' && $data['payment_method'] === 'Rechnung')
            {
                $termDays = $data['payment_term_days'] ?? 14;
                $dueDate = now()->addDays($termDays);
            }

            $sale->invoice()->create([
                'customer_id' => $sale->customer_id,
                'invoice_number' => $sale->id,
                'status' => 'offen',
                'date' => now(),
                'payment_term_days' => $termDays,
                'due_date' => $dueDate,
            ]);

        return redirect()->route('sales.index')->with('success', 'Verkauf gebucht');
    }
}
