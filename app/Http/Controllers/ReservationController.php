<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['customer', 'article'])->latest()->get();
        return view('reservations.index', ['reservations' => $reservations]);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate(['status' => 'required']);
        $reservation->update(['status' => $data['status']]);
        return back();
    }
}
