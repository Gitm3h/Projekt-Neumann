<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    public function edit()
    {
        return view('auth.password-change');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->symbols()->mixedCase()->numbers()],
        ]);

        $request->user()->update([
            'password' => $request->password,
            'must_change_password' => false,
        ]);
        return redirect()->route('dashboard');
    }
}
