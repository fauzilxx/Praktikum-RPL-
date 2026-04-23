<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminLoginController extends Controller
{
    /**
     * Tampilkan halaman login admin.
     */
    public function create()
    {
        return Inertia::render('Auth/AdminLogin');
    }

    /**
     * Proses login admin menggunakan guard 'admin'.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password admin salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended('/admin/dashboard');
    }

    /**
     * Logout admin.
     */
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
