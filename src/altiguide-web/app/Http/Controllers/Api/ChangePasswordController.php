<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    /**
     * Ganti password (user sudah login via Sanctum token).
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        // Cek password lama
        if (! Hash::check($request->current_password, $request->user()->password)) {
            return response()->json([
                'message' => 'Password lama tidak sesuai.',
                'errors'  => ['current_password' => ['Password lama tidak sesuai.']],
            ], 422);
        }

        // Update password
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Password berhasil diubah!',
        ]);
    }
}
