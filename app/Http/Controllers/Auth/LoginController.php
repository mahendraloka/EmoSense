<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('/login');
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email'    => 'required',
    //         'password' => 'required',
    //     ]);

    //     if (Auth::guard('admin')->attempt([
    //         'email' => $request->email,
    //         'password' => $request->password
    //     ])) {
    //         return redirect('/admin/dashboard');
    //     }
        
    //     if (Auth::guard('psikolog')->attempt([
    //         'email' => $request->email,
    //         'password' => $request->password
    //     ])) {
    //         return redirect('/psikolog/dashboard');
    //     }
        
    //     if (Auth::guard('mahasiswa')->attempt([
    //         'email' => $request->email,
    //         'password' => $request->password
    //     ])) {
    //         return redirect('/mahasiswa/home');
    //     }        

    //     return back()->withErrors(['email' => 'Email atau password salah']);
    // }
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email','password'))) {
            $request->session()->regenerate();
            $request->session()->regenerateToken();
            return redirect('/admin/dashboard');
        }

        if (Auth::guard('psikolog')->attempt($request->only('email','password'))) {
            $request->session()->regenerate();
            $request->session()->regenerateToken();
            return redirect('/psikolog/dashboard');
        }

        if (Auth::guard('mahasiswa')->attempt($request->only('email','password'))) {
            $request->session()->regenerate();
            $request->session()->regenerateToken();
            return redirect('/mahasiswa/home');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }
}
