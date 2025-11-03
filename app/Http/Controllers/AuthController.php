<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login'); // login.blade.php
    }

    public function showRegister()
    {
        return view('register'); // register.blade.php
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'error' => 'Invalid email or password.'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name'      => 'required',
            'middle_name'     => 'required',
            'last_name'       => 'required',
            'suffix'          => 'nullable',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:6',
            'confirm_password'=> 'required|same:password',
        ]);

        // Insert to DB
        User::create([
            'first_name'  => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name'   => $request->last_name,
            'suffix'      => $request->suffix,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
