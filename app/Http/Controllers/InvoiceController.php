<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function pdf(Sale $sale)
    {
        $sale->load('items.article', 'customer', 'invoice');
        $pdf = PDF::loadView('invoices.pdf', ['sale' => $sale]);
        return $pdf->stream('Rechnung-' . $sale->id . '.pdf');
    }
}
