<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Registrasi user baru dan langsung return token.
     */
    public function register(Request $request)
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
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem kami.',
            'nik.size'   => 'NIK harus tepat 16 angka.',
        ]);

        $user = User::create($validated);

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil!',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }

    /**
     * Login dan return Bearer token.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.',
            ], 401);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil!',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    /**
     * Logout — revoke token yang sedang dipakai.
     */
    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan saja
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil!',
        ]);
    }

    /**
     * Ambil data profil user yang sedang login.
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Update profil user (dari mobile app).
     * Semua field bersifat optional (partial update).
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name'              => ['sometimes', 'string', 'max:100'],
            'phone_number'      => ['sometimes', 'string', 'max:15'],
            'age'               => ['sometimes', 'integer', 'min:1', 'max:120'],
            'address'           => ['sometimes', 'string'],
            'emergency_contact' => ['sometimes', 'string', 'max:15'],
        ]);

        $request->user()->update($validated);

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user'    => $request->user()->fresh(),
        ]);
    }
}
