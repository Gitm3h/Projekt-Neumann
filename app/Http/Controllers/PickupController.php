<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pickup;
use App\Models\Article;
use App\Models\Stock;
use App\Models\StockMovement;

class PickupController extends Controller
{
    public function create()
    {
        $articles = Article::with('stocks')->oderBy('name')->get()->filter(fn ($a) => $a->stocks->sum('quantity') > 0)->values();
        return view('pickup.create', ['articles' => $articles]);
    }

    public function store(Request $request)
    {

    }
}
