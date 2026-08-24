<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Customer;
use App\Models\ReservationItem;
use App\Models\Reservation;

class PortalController extends Controller
{
    public function index()
    {
        $customer =Customer::where('user_id', auth()->id())->first();

        $reservierungen = collect();
        if ($customer) {
            $reservierungen = Reservation::where('customer_id', $customer->id)->where('status', 'reserviert')
                ->with('items.article')
                ->get();
        }

        $anzahl = $reservierungen->count();
        $wert = $reservierungen->sum(function ($r) {
            return $r->items->sum(fn ($i) => $i->quantity * $i->article->price);
        });

        return view('portal.index', ['anzahl' => $anzahl, 'wert' => $wert]);
    }

    public function articles()
    {
        $articles = Article::orderBy('name')->get();
        return view('portal.articles', ['articles' => $articles]);
    }

    public function reservations()
    {
        $customer =Customer::where('user_id', auth()->id())->first();
        $reservations = $customer ? Reservation::where('customer_id', $customer->id)->with('items.article')->latest()->get() : collect();
        return view('portal.reservations', ['reservations' => $reservations]);
    }

    public function reserve(Request $request)
    {
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*.article_id' => ['nullable', 'exists:articles,id'],
            'items.*.quantity' => ['nullable', 'integer', 'min:1']

        ]);

        $lines = collect($data['items'])->filter(function ($row) {
            return !empty($row['article_id']) && ($row['quantity'] ?? 0) > 0;
        });

        if ($lines->isEmpty()) {
            return  back()->withErrors(['items' => 'Bitte mindestens einen Artikel wählen.']);
        }

        $customer = Customer::where('user_id', auth()->id())->firstOrFail();

        $reservation = Reservation::create([
            'customer_id' => $customer->id,
            'status'      => 'reserviert',
            'date'        => now(),
        ]);

        foreach ($lines as $row) {
            $reservation->items()->create([
                'article_id' => $row['article_id'],
                'quantity'   => $row['quantity'],
            ]);
    }

        return redirect()->route('portal.reservations')->with('status', 'Reserviert!');
    }

    public function cancel(Reservation $reservation)
    {
        $customer = Customer::where('user_id', auth()->id())->firstOrFail();
        abort_unless($reservation->customer_id === $customer->id, 403);

        if ($reservation->status === 'reserviert') {
            $reservation->update(['status' => 'storniert']);
        }
        return back()->with('status', 'Reservierung storniert.');
    }

    public function updateItem(Request $request, ReservationItem $item)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $customer = Customer::where('user_id', auth()->id())->firstOrFail();
        abort_unless($item->reservation->customer_id === $customer->id, 403);
        abort_unless($item->reservation->status === 'reserviert', 403);

        $item->update(['quantity' => $data['quantity']]);
        return back()->with('status', 'Menge aktualisiert.');
    }
}
