<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Article;

class ReportController extends Controller
{
    public function zBericht()
    {
        $sales = Sale::whereDate('date', today())->get();

        $data = [
            'anzahl' => $sales->count(),
            'umsatz' => $sales->sum('total'),
            'nachZahlart' => $sales->groupBy('payment_method')
            ->map(fn ($g) => $g->sum('total')),
        ];

        return view('reports.z', $data);
    }

    public function niedrig()
    {
        $artikel = Article::with('stocks')->get()
            ->filter(fn ($a) => $a->stocks->sum('quantity') < $a->min_stock);

        return view('reports.low-stock', ['artikel' => $artikel]);
    }
}
