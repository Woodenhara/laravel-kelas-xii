<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('templates.component.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password]))
        {
            $request->session()->regenerate();
            if (auth()->user()->level == 'user')
            { return redirect()->route('pembayaran.index'); } else
            { return redirect()->route('spp.sppc.index'); }
        }
        return back()->withErrors([
            'notif' => 'Credential do not match with our records',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login')->withSuccess('Anda Telah Keluar Dari Sistem');
    }
}
