<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordChangeController extends Controller
{
    public function edit()
    {
        return view('auth.password-change');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => $request->password,
            'must_change_password' => false,
        ]);
        return redirect()->route('dashboard');
    }
}
