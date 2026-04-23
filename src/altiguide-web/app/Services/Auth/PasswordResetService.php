<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Mail\ResetPasswordCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PasswordResetService
{
    /**
     * Kirim email kode OTP untuk reset password ke pengguna.
     */
    public function sendResetCode(string $email): void
    {
        $user = User::where('email', $email)->firstOrFail();
        
        $code = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        DB::transaction(function () use ($email, $user, $code) {
            DB::table('password_reset_codes')->where('email', $email)->delete();

            DB::table('password_reset_codes')->insert([
                'email'       => $user->email,
                'code'        => $code,
                'expires_at'  => Carbon::now()->addMinutes(15),
                'is_verified' => false,
                'created_at'  => Carbon::now(),
            ]);
        });

        Mail::to($user->email)->send(new ResetPasswordCode($code, $user->name));
    }

    /**
     * Memverifikasi apakah kode OTP yang dimasukkan valid dan belum kedaluwarsa.
     */
    public function verifyResetCode(string $email, string $code): void
    {
        $resetData = DB::table('password_reset_codes')
            ->where('email', $email)
            ->where('code', $code)
            ->first();

        if (!$resetData) {
            throw ValidationException::withMessages(['code' => 'Kode OTP tidak valid.']);
        }

        if (Carbon::now()->greaterThan($resetData->expires_at)) {
            throw ValidationException::withMessages(['code' => 'Kode OTP telah kedaluwarsa.']);
        }

        DB::table('password_reset_codes')
            ->where('id', $resetData->id)
            ->update(['is_verified' => true]);
    }

    /**
     * Mengeksekusi penukaran password baru yang sudah divalidasi dan terverifikasi.
     */
    public function resetPassword(string $email, string $code, string $newPassword): void
    {
        $resetData = DB::table('password_reset_codes')
            ->where('email', $email)
            ->where('code', $code)
            ->first();

        if (!$resetData || !$resetData->is_verified) {
            throw ValidationException::withMessages(['email' => 'Permintaan reset password tidak valid atau belum diverifikasi.']);
        }

        if (Carbon::now()->greaterThan($resetData->expires_at)) {
            throw ValidationException::withMessages(['email' => 'Sesi ubah password telah kedaluwarsa.']);
        }

        DB::transaction(function () use ($email, $newPassword) {
            $user = User::where('email', $email)->firstOrFail();
            $user->password = Hash::make($newPassword);
            $user->save();

            DB::table('password_reset_codes')->where('email', $email)->delete();
        });
    }
}