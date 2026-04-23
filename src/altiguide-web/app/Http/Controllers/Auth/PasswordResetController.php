<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendResetCodeRequest;
use App\Http\Requests\Auth\VerifyResetCodeRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Auth\PasswordResetService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PasswordResetController extends Controller
{
    private PasswordResetService $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Tampilkan halaman Form Lupa Password (input email)
     */
    public function showLinkRequestForm()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * Tampilkan halaman Form Input Kode OTP
     */
    public function showVerifyCodeForm(Request $request)
    {
        return Inertia::render('Auth/VerifyResetCode', [
            'email' => $request->query('email')
        ]);
    }

    /**
     * Tampilkan halaman Form Reset Password (input password baru)
     */
    public function showResetForm(Request $request)
    {
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->query('email'),
            'code'  => $request->query('code'),
        ]);
    }

    /**
     * Proses pengiriman email berisi OTP ke user
     */
    public function sendResetCodeEmail(SendResetCodeRequest $request)
    {
        $this->passwordResetService->sendResetCode($request->validated('email'));

        return redirect()->route('password.verify', ['email' => $request->validated('email')])
                         ->with('status', 'Kode reset password (OTP) telah dikirim ke email Anda.');
    }

    /**
     * Proses pengecekan/verifikasi kode OTP yg diinput user
     */
    public function verifyResetCode(VerifyResetCodeRequest $request)
    {
        $this->passwordResetService->verifyResetCode(
            $request->validated('email'),
            $request->validated('code')
        );

        return redirect()->route('password.reset', [
            'email' => $request->validated('email'),
            'code'  => $request->validated('code')
        ])->with('status', 'Kode OTP valid, silahkan masukkan password yang baru.');
    }

    /**
     * Proses penggantian password baru setelah OTP benar
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->passwordResetService->resetPassword(
            $request->validated('email'),
            $request->validated('code'),
            $request->validated('password')
        );

        return redirect()->route('login')
                         ->with('status', 'Password berhasil diubah. Silahkan login dengan password baru.');
    }
}
