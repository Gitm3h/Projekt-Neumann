<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customers.index', ['customers' => Customer::orderBy('name')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:privat,gewerblich'],
            'street' => ['nullable', 'string'],
            'house_number' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'vat_id' => ['nullable', 'string'],
        ]);
        Customer::create($data);
        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:privat,gewerblich'],
            'street' => ['nullable', 'string'],
            'house_number' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'vat_id' => ['nullable', 'string'],
        ]);
        $customer->update($data);
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
