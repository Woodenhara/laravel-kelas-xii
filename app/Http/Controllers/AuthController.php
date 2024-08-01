<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('templates.component.login');  // Sesuaikan dengan view login Anda
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('name', 'password');
        // \Log::info('Attempting login with credentials:', $credentials);

        if (Auth::attempt($credentials)) {
            // \Log::info('Login successful for user:', ['user' => Auth::user()]);
            // return redirect()->intended('/')
            //                 ->withSuccess('Login successful');
            $request->session()->regenerate();
            if (Auth::user()->role_id == '1') {
                return redirect()->route('home');
            } else {
                return redirect()->route('home');
            }
        }
        // \Log::warning('Login failed for credentials:', $credentials);
        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
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
