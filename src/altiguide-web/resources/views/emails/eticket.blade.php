<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket Pendakian AltiGuide</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eaeaea; border-radius: 8px; }
        .header { background-color: #2F855A; color: white; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; line-height: 1.6; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; border-top: 1px solid #eaeaea; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>AltiGuide - Booking Berhasil!</h2>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $transaction->user->name }}</strong>!</p>
            <p>Pembayaran Anda untuk pendakian Gunung <strong>{{ $transaction->hikingSession->route->mountain->name }}</strong> telah berhasil kami terima. Terima kasih telah menggunakan layanan AltiGuide.</p>
            
            <p><strong>Detail Reservasi:</strong></p>
            <ul>
                <li><strong>Order ID:</strong> {{ $transaction->order_id }}</li>
                <li><strong>Grup Pendakian:</strong> {{ $transaction->hikingSession->group_name }} ({{ $transaction->hikingSession->members->count() }} orang)</li>
                <li><strong>Jadwal Mendaki:</strong> {{ \Carbon\Carbon::parse($transaction->hikingSession->start_date)->format('d F Y') }}</li>
            </ul>

            <p>Bersamaan dengan email ini, kami telah <strong>melampirkan E-Ticket resmi (PDF)</strong> untuk pendakian Anda.</p>
            
            <p style="color: #c53030; font-weight: bold;">⚠️ PENTING: <br>
            Harap siapkan dan tunjukkan E-Ticket (PDF) dan Order ID Anda kepada petugas/ranger yang berjaga di Pos Basecamp sebelum melakukan pendakian.</p>
            
            <p>Berdoa sebelum mendaki, jangan tinggalkan apapun selain jejak, dan selamat menikmati keindahan alam Indonesia!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} AltiGuide Indonesia. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
