<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket AltiGuide</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.4;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2ecc71;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #2ecc71;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #7f8c8d;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .details-table th, .details-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .details-table th {
            background-color: #f9f9f9;
            width: 30%;
        }
        .members-title {
            background-color: #2ecc71;
            color: white;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        .members-table {
            width: 100%;
            border-collapse: collapse;
        }
        .members-table th, .members-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .members-table th {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #95a5a6;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <table style="width: 100%; border-bottom: 2px solid #2ecc71; padding-bottom: 15px; margin-bottom: 20px;">
        <tr>
            <td style="width: 70%; text-align: left;">
                <h1 style="color: #2ecc71; margin: 0; font-size: 28px;">ALTIGUIDE E-TICKET</h1>
                <p style="margin: 5px 0 0 0; color: #7f8c8d;">Surat Izin Masuk Kawasan Konservasi (SIMAKSI)</p>
            </td>
            <td style="width: 30%; text-align: right;">
                <img src="data:image/svg+xml;base64,{!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(90)->margin(0)->generate($transaction->order_id)) !!}" alt="QR Code">
                <div style="font-size: 10px; color: #7f8c8d; margin-top: 5px;">Scan at Basecamp</div>
            </td>
        </tr>
    </table>

    <table class="details-table">
        <tr>
            <th>Order ID</th>
            <td><strong>{{ $transaction->order_id }}</strong></td>
        </tr>
        <tr>
            <th>Nama Rombongan</th>
            <td>{{ $transaction->hikingSession->group_name }}</td>
        </tr>
        <tr>
            <th>Ketua Rombongan</th>
            <td>{{ $transaction->user->name }}</td>
        </tr>
        <tr>
            <th>Tujuan Pendakian</th>
            <td>Gunung {{ $transaction->hikingSession->route->mountain->name ?? '-' }} (Jalur {{ $transaction->hikingSession->route->name ?? '-' }})</td>
        </tr>
        <tr>
            <th>Tanggal Naik</th>
            <td>{{ \Carbon\Carbon::parse($transaction->hikingSession->start_date)->format('d F Y') }}</td>
        </tr>
        <tr>
            <th>Tipe Pendakian</th>
            <td>{{ strtoupper($transaction->hikingSession->hike_type) }}</td>
        </tr>
        <tr>
            <th>Status Pembayaran</th>
            <td style="color: green; font-weight: bold;">LUNAS</td>
        </tr>
    </table>

    <div class="members-title">Daftar Anggota Rombongan</div>
    <table class="members-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Nomor Identitas (NIK)</th>
                <th>Kontak Darurat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->hikingSession->members as $index => $member)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $member->full_name }}</td>
                <td>{{ $member->identity_number }}</td>
                <td>{{ $member->emergency_contact }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Harap tunjukkan E-Ticket ini beserta Kartu Identitas asli Anda kepada petugas Basecamp sebelum melakukan pendakian.
        <br>
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}
    </div>

</body>
</html>
