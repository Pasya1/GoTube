<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/home');
            } elseif ($user->role === 'kurir') {
                return redirect()->intended('/home');
            } elseif ($user->role === 'spv') {
                return redirect()->intended('/home');
            }
        }

        return back()->withErrors([
            'name' => 'Email atau password salah.',
        ]);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
