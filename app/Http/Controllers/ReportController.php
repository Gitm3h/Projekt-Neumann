<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

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
}
