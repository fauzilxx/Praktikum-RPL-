<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman form registrasi.
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:100'],
            'email'             => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'password'          => ['required', 'confirmed', Password::min(8)],
            'phone_number'      => ['required', 'string', 'max:15'],
            'age'               => ['required', 'integer', 'min:1', 'max:120'],
            'address'           => ['required', 'string'],
            'emergency_contact' => ['required', 'string', 'max:15'],
            'nik'               => ['required', 'string', 'size:16', 'unique:users,nik'],
        ],[
            'nik.unique' => 'NIK ini sudah terdaftar di sistem kami.',
            'nik.size'   => 'NIK harus tepat 16 angka.',
        ]);

        $user = User::create($validated);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }
}

