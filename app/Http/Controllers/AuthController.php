<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);

        // Attempt login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            $user = Auth::user();
            
            if ($user->isSuperAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->isCasemix()) {
                return redirect()->intended('/casemix/dashboard');
            } elseif ($user->isKeuangan()) {
                return redirect()->intended('/keuangan/dashboard');
            }

            // Fallback redirect
            return redirect()->intended('/dashboard');
        }

        // Login gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout');
    }
}