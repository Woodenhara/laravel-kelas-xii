<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        // \Log::info('Attempting login with credentials:', $credentials);

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            // \Log::info('Login successful for user:', ['user' => Auth::user()]);
            // return redirect()->intended('/')
            //                 ->withSuccess('Login successful');
            $request->session()->regenerate();
            if (Auth()->user()->role_id == '1') {
                return redirect()->route('home');
            } else if (Auth()->admin()->role_id == '2') {
                return redirect()->route('movies');
            } else {
                return ('Login failed for credentials.');
            };
        }
        // \Log::warning('Login failed for credentials:', $credentials);
        return back()->withErrors([
            'Login failed for credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->withSuccess('Anda Telah Keluar Dari Sistem');
    }
}
