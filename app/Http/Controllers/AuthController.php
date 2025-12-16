<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // 1. TAMPILKAN FORM LOGIN
    public function showLogin()
    {
        return view('auth.login');
    }

    // 2. PROSES LOGIN (CEK PASSWORD)
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Username & Password KITA SET MANUAL DI SINI
        if ($username === 'admin' && $password === 'admin') {
            
            // Simpan "tiket" login ke sesi browser
            session(['is_dosen' => true]);
            
            return redirect()->route('assignments.index');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    // 3. PROSES LOGOUT
    public function logout()
    {
        session()->forget('is_dosen'); // Buang tiket login
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}