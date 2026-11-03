<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Proses login user dan inisialisasi session.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $pesan = 'Selamat datang, ' . $user->name . '! Anda login sebagai ' . ucfirst($user->role) . '.';

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))->with('success', $pesan);
            } else {
                return redirect()->intended(route('pembeli.shop'))->with('success', $pesan);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password yang dimasukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan halaman register.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.register');
    }

    /**
     * Proses pendaftaran akun baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|in:admin,pembeli',
        ]);

        $role = $request->input('role', 'pembeli');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $role,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $pesan = 'Pendaftaran berhasil! Selamat datang, ' . $user->name . '.';

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', $pesan);
        } else {
            return redirect()->route('pembeli.shop')->with('success', $pesan);
        }
    }

    /**
     * Logout user dan hapus session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar (logout).');
    }

    /**
     * Helper redirect berdasarkan role.
     */
    private function redirectBasedOnRole($user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('pembeli.shop');
    }
}

