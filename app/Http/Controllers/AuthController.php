<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register()
    {
        return view('save.regist');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required',
            'nama' => 'required',
            'email' => 'required|email',
            'no_telepon' => 'nullable|number',
            'password' => 'required|min:8',
            'confirm-password' => 'required|same:password'
        ]);
        $data = $request->except('confirm-password', 'password');
        $data['password'] = Hash::make($validate['password']);
        User::create($data);

        Session::flash('success_message', 'Akun berhasil terdaftar! Silakan masuk.');
        return redirect('/login')->with('success', 'Akun Berhasil Dibuat');
    }
    
    public function login()
    {
        return view('save.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Session::flash('success_message', 'Login berhasil');
 
            if (Auth::user()->role == 'admin') {
                return redirect()->intended(route('admin.index'))->with('success', 'Welcome ' . Auth::user()->nama);
            }

            return redirect()->intended('/')->with('success', 'Selamat Datang ' . Auth::user()->nama);
        }
 
        Session::flash('status', 'failed');
        Session::flash('message', 'Login Gagal!');

        return redirect('/login')->with('error', 'Email/Password Salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/')->with('success', 'Terima Kasih :D');
    }
}
