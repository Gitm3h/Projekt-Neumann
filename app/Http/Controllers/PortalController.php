<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Customer;
use App\Models\Reservation;

class PortalController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('name')->get();
        return view('portal.index', ['articles' => $articles]);
    }

    public function reserve(Request $request)
    {
        $data = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'quantity' => 'required|integer|min:1',
        ]);

        //zum einloggen Nutzer den passenden Kunden holen
        $customer = Customer::where('user_id', auth()->id())->firstOrFail();

        Reservation::create([
            'customer_id' => $customer->id,
            'article_id'  => $data['article_id'],
            'quantity'    => $data['quantity'],
            'status'      => 'reserviert',
            'date'        => now(),
        ]);

        return back()->with('status', 'Reserviert!');
    }
}
