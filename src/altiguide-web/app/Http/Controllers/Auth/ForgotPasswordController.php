<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan halaman forgot password.
     */
    public function create()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * Tampilkan halaman input kode OTP.
     */
    public function showVerifyForm(Request $request)
    {
        return Inertia::render('Auth/VerifyResetCode', [
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Tampilkan halaman reset password (setelah kode terverifikasi).
     */
    public function showResetForm(Request $request)
    {
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->query('email'),
            'code'  => $request->query('code'),
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // STEP 1: Kirim kode OTP ke email
    // ─────────────────────────────────────────────────────────────────────

    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Email tidak ditemukan di sistem kami.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Hapus kode lama untuk email ini
        DB::table('password_reset_codes')->where('email', $request->email)->delete();

        // Generate kode OTP 6 digit
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan kode OTP
        DB::table('password_reset_codes')->insert([
            'email'      => $request->email,
            'code'       => $code,
            'expires_at' => now()->addMinutes(15),
            'created_at' => now(),
        ]);

        // Kirim email
        Mail::to($request->email)->send(new ResetPasswordCode($code, $user->name));

        return back()->with('success', 'Kode verifikasi telah dikirim ke email kamu.');
    }

    // ─────────────────────────────────────────────────────────────────────
    // STEP 2: Verifikasi kode OTP
    // ─────────────────────────────────────────────────────────────────────

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'code'  => ['required', 'string', 'size:6'],
        ]);

        $record = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (! $record) {
            return back()->withErrors([
                'code' => 'Kode tidak valid atau sudah kedaluwarsa.',
            ]);
        }

        // Tandai kode sebagai terverifikasi
        DB::table('password_reset_codes')
            ->where('id', $record->id)
            ->update(['is_verified' => true]);

        return redirect()->route('password.reset.form', [
            'email' => $request->email,
            'code'  => $request->code,
        ])->with('success', 'Kode terverifikasi! Silakan buat password baru.');
    }

    // ─────────────────────────────────────────────────────────────────────
    // STEP 3: Reset password
    // ─────────────────────────────────────────────────────────────────────

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'code'     => ['required', 'string', 'size:6'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Verifikasi ulang kode (harus sudah terverifikasi & belum expired)
        $record = DB::table('password_reset_codes')
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->where('is_verified', true)
            ->where('expires_at', '>', now())
            ->first();

        if (! $record) {
            return back()->withErrors([
                'code' => 'Kode tidak valid, sudah dipakai, atau sudah kedaluwarsa.',
            ]);
        }

        // Update password user
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Hapus semua kode OTP untuk email ini
        DB::table('password_reset_codes')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login.');
    }
}
