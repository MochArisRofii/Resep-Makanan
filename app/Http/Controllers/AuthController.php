<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Login Method
    public function loginForm()
    {
        return view('auth.login'); // Halaman login
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home'); // Arahkan ke halaman home setelah login
        } else {
            return back()->withErrors(['email' => 'Email atau password salah']);
        }
    }

    // Logout Method
    public function logout()
    {
        Auth::logout(); // Melakukan logout
        return redirect()->route('login'); // Arahkan kembali ke halaman login
    }
}
