<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // FORM LOGIN
    public function login()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate(); // WAJIB

            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat Datang Admin!');
            }

            if ($role === 'staff') {
                return redirect()->route('staff.dashboard')
                    ->with('success', 'Selamat Datang Staff!');
            }
        }

        return back()->withErrors(['login' => 'email atau password salah!'])
            ->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
