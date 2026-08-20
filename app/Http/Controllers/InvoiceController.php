<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function pdf(Sale $sale)
    {
        $sale->load('items.article', 'customer', 'invoice');
        $pdf = PDF::loadView('invoices.pdf', ['sale' => $sale]);
        return $pdf->stream('Rechnung-' . $sale->id . '.pdf');
    }

    public function index()
    {
        $invoices = Invoice::with('customer', 'sale')->latest()->get();
        return view('invoices.index', ['invoices' => $invoices]);
    }

    public function markPaid(Invoice $invoice)
    {
        $invoice->update(['status' => 'bezahlt', 'paid_at' => now()]);
        return back();
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Rechnung gelöscht');
    }
}
