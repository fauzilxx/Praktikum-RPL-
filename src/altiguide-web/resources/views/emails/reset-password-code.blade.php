<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f7fa; margin: 0; padding: 20px; }
        .container { max-width: 480px; margin: 0 auto; background: #fff; border-radius: 12px; padding: 40px 32px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .logo { text-align: center; font-size: 24px; font-weight: 700; color: #2563eb; margin-bottom: 24px; }
        .code-box { background: #f0f6ff; border: 2px dashed #2563eb; border-radius: 8px; text-align: center; padding: 20px; margin: 24px 0; }
        .code { font-size: 36px; font-weight: 800; letter-spacing: 8px; color: #1e40af; }
        .text { color: #374151; font-size: 15px; line-height: 1.6; }
        .footer { text-align: center; color: #9ca3af; font-size: 12px; margin-top: 32px; }
        .warning { color: #dc2626; font-size: 13px; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🏔️ AltiGuide</div>

        <p class="text">Halo <strong>{{ $userName }}</strong>,</p>

        <p class="text">Kami menerima permintaan untuk mereset password akun AltiGuide kamu. Gunakan kode berikut untuk melanjutkan:</p>

        <div class="code-box">
            <div class="code">{{ $code }}</div>
        </div>

        <p class="text">Kode ini berlaku selama <strong>15 menit</strong>. Jangan bagikan kode ini kepada siapapun.</p>

        <p class="warning">⚠️ Jika kamu tidak meminta reset password, abaikan email ini.</p>

        <div class="footer">
            &copy; {{ date('Y') }} AltiGuide — Teman Pendakian Kamu
        </div>
    </div>
</body>
</html>
