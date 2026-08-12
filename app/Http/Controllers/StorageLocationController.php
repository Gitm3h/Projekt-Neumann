<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StorageLocation;

class StorageLocationController extends Controller
{
    public function index()
    {
        $locations = StorageLocation::withCount('stocks')->get();
        return view('storage-locations.index', compact('locations'));
    }
    public function create() {
        return view('storage-locations.create');
    }
    public function store(Request $request) {
        $data = $request->validate(['name' => 'required']);
        StorageLocation::create($data);
        return redirect()->route('storage-locations.index');
    }
    public function edit($id) {
        $location = StorageLocation::findOrFail($id);
        return view('storage-locations.edit', ['location' => $location]);
    }
    public function update(Request $request, $id) {
        $data = $request->validate(['name' => 'required']);
        StorageLocation::findOrFail($id)->update($data);
        return redirect()->route('storage-locations.index');
    }
    public function destroy($id) {
        StorageLocation::findOrFail($id)->delete();
        return redirect()->route('storage-locations.index');
    }

    public function show($id) {
        $location = StorageLocation::with('stocks.articles')->findOrFail($id);
        return view('storage-locations.show', ['location' => $location]);
    }
}
