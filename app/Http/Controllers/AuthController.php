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

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            $request->session()->regenerate();
            if (auth()->user()->level == 'user') {
                return('BERHASIL'); 
            } else {
                return('BERHASIL LOGIN');
            }
        }

        return('GAGAL LOGIN');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->withSuccess('Anda Telah Keluar Dari Sistem');
    }
}
