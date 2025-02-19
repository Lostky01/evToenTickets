<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'nis' => 'nullable',
            'password' => 'required',
        ]);

        // Cek apakah login menggunakan NIS atau Email
        if ($request->nis) {
            // Login untuk siswa internal
            $user = Users::where('nis', $request->nis)->first();
        } elseif ($request->email) {
            // Login untuk pengguna eksternal
            $user = Users::where('email', $request->email)->first();
        } else {
            return back()->with('error', 'Harap isi NIS atau Email untuk login.');
        }

        // Validasi user dan password
        if ($user && $user->password === $request->password) {
            // Simpan user ke session
            session(['user' => $user]);
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'NIS/Email atau password salah.');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'nis' => 'nullable|unique:users,nis',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Pastikan salah satu diisi: email untuk eksternal atau NIS untuk internal
        if (empty($request->email) && empty($request->nis)) {
            return back()->with('error', 'Harap isi NIS atau Email untuk mendaftar.');
        }

        // Buat user baru
        $user = new Users();
        $user->name = $request->name;

        if ($request->nis) {
            $user->nis = $request->nis; // Untuk siswa internal
        } elseif ($request->email) {
            $user->email = $request->email; // Untuk pengguna eksternal
        }

        $user->password = $request->password; // Tanpa hashing sesuai permintaan
        $user->save();

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

}
