<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['customer', 'items.article'])->latest()->get();
        return view('reservations.index', ['reservations' => $reservations]);
    }

    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate(['status' => 'required']);
        $reservation->update(['status' => $data['status']]);
        return back()->with('success', 'Status aktualisiert');
    }

    /**
     * Delete a reservation (only if status is abgeholt or storniert)
     */
    public function destroy(Reservation $reservation)
    {
        if (!in_array($reservation->status, ['abgeholt', 'storniert'])) {
            return back()->withErrors([
                'error' => 'Reservierung kann nur gelöscht werden, wenn sie abgeholt oder storniert ist.'
            ]);
        }

          $reservation->items()->delete();


        $reservation->delete();

        return redirect()->route('reservations.index')
            ->with('success', 'Reservierung gelöscht.');
    }


}
