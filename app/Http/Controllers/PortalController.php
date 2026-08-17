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
        return view('portal.index');
    }

    public function articles()
    {
        $articles = Article::orderBy('name')->get();
        return view('portal.articles', ['articles' => $articles]);
    }

    public function reservations()
    {
        $customer =Customer::where('user_id', auth()->id())->first();
        $reservations = $customer ? Reservation::where('customer_id', $customer->id)->with('article')->latest()->get() : collect();
        return view('portal.reservations', ['reservations' => $reservations]);
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
