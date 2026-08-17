<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Article;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function zBericht(Request $request)
    {
        $datum = $request->input('datum', today()->toDateString());
        $sales = Sale::whereDate('date', $datum)->get();
        $niedrig = Article::with('stocks')->get()
            ->filter(fn ($a) => $a->stocks->sum('quantity') < $a->min_stock);

        return view('reports.z', [
            'datum' => $datum,
            'anzahl' => $sales->count(),
            'umsatz' => $sales->sum('total'),
            'nachZahlart' => $sales->groupBy('payment_method')->map(fn ($g) => $g->sum('total')),
            'niedrig' => $niedrig,
        ]);
    }

    public function zBerichtPdf(Request $request)
    {
        $datum = $request->input('datum', today()->toDateString());
        $sales = Sale::whereDate('date', $datum)->get();
        $niedrig = Article::with('stocks')->get()
            ->filter(fn ($a) => $a->stocks->sum('quantity') < $a->min_stock);

        $pdf = Pdf::loadView('reports.z-pdf', [
            'datum' => $datum,
            'anzahl' => $sales->count(),
            'umsatz' => $sales->sum('total'),
            'nachZahlart' => $sales->groupBy('payment_method')->map(fn ($g) => $g->sum('total')),
            'niedrig' => $niedrig,
        ]);

        return $pdf->stream('Z-Bericht' . $datum . '.pdf');
    }

    public function niedrig()
    {
        $artikel = Article::with('stocks')->get()
            ->filter(fn ($a) => $a->stocks->sum('quantity') < $a->min_stock);
        return view('reports.low-stock', ['artikel' => $artikel]);
    }
}
