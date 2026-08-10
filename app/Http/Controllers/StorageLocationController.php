<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StorageLocation;

class StorageLocationController extends Controller
{
    public function index()
    {
        $locations = StorageLocation::all();

        return view('storage-locations.index', compact('locations'));
    }
}
