<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Customer;
use App\Models\User;


class CustomerController extends Controller
{

    public function index()
    {
        return view('customers.index', ['customers' => Customer::orderBy('name')->get()]);
    }


    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'type' => ['required', 'in:privat,gewerblich'],
            'street' => ['nullable', 'string'],
            'house_number' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'vat_id' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'kunde',
            'must_change_password' => true,
        ]);

        Customer::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'type' => $data['type'],
            'street' => $data['street'] ?? null,
            'house_number' => $data['house_number'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'city' => $data['city'] ?? null,
            'vat_id' => $data['vat_id'] ?? null,
        ]);

        return redirect()->route('customers.index')->with('success', 'Kunde und Portal-Login angelegt');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', ['customer' => $customer]);
    }

    public function update(Request $request, Customer $customer)
    {
        $user = $customer->users;

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->ignore($user?->id)],
            'password' => [$user ? 'nullable': 'required', 'string', 'min:8'],
            'type' => ['required', 'in:privat,gewerblich'],
            'street' => ['nullable', 'string'],
            'house_number' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'vat_id' => ['nullable', 'string'],
        ]);

        if ($user) {
            $user->name = $data['name'];
            $user->email = $data['email'];
            if (! empty($data['password'])) {
                $user->password = $data['password'];
            }
            $user->save();
        } else {
            $user =User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'kunde',
                'must_change_password' => true,
            ]);
        }

        $customer->update([
            'user_id' => $user->id,
            'name' => $data['name'],
            'type' => $data['type'],
            'street' => $data['street'] ?? null,
            'house_number' => $data['house_number'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'city' => $data['city'] ?? null,
            'vat_id' => $data['vat_id'] ?? null,
        ]);

        return redirect()->route('customers.index')->with('success', 'Kunde gespeichert');
    }

    public function destroy(Customer $customer)
    {
        $user = $customer->users;
        try {
            $customer->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('customers.index')->with('error', 'Kunde kann nicht gelöscht werden, da noch Rechnungen vorhanden sind.');
        }
        $user?->delete();

        return redirect()->route('customers.index')->with('success', 'Kunde gelöscht');
    }

    public function resetPassword(Customer $customer)
    {
        $user = $customer->users;

        if (! $user) {
            return back()->with('status', 'Dieser Kunde hat keinen Portal_login.');
        }

        $newPassword = Str::random(10);
        $user->update([
            'password' => $newPassword,
            'must_change_password' => true,
        ]);

        return redirect()->route('customers.index')->with('status', 'Neues Passwort für' . ': ' . $newPassword);
    }
}
