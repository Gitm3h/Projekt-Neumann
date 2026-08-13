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
}
