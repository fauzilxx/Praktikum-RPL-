<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\HikingSession;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    /**
     * Memsindai (Scan) Tiket / QR Code berdasarkan Order ID
     * Menampilkan status pesanan, daftar member, dll.
     */
    public function scan(Request $request, $orderId)
    {
        // Ambil data admin yang sedang request/scan (bisa dari Sanctum atau session admin)
        $admin = $request->user('admin') ?? $request->user();

        // Cari transaksi beserta relasinya
        $transaction = Transaction::with([
            'hikingSession.route.mountain',
            'hikingSession.members',
            'user' // Ketua yang memesan
        ])->where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tiket tidak ditemukan di sistem. Harap cek kembali Order ID.'
            ], 404);
        }

        // --- VALIDASI WEWENANG POS PENJAGAAN ADMIN ---
        // Jika admin adalah basecamp_staff, pastikan dia hanya bisa scan tiket rute-nya sendiri
        if ($admin && $admin->role === 'basecamp_staff' && $admin->route_id) {
            $tiketRouteId = $transaction->hikingSession->route_id;
            if ($admin->route_id !== $tiketRouteId) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Akses Ditolak: Tiket ini bukan untuk jalur pos penjagaan Anda. (Wewenang Rute Tidak Sesuai)'
                ], 403);
            }
        }

        if ($transaction->status !== 'settlement') {
            return response()->json([
                'status'  => 'error',
                'message' => 'PERINGATAN: Tiket ini berstatus [' . strtoupper($transaction->status) . ']. Belum Lunas atau Kadaluwarsa!',
                'data'    => $transaction
            ], 400); // 400 Bad Request karena tiketnya bermasalah
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data tiket Valid dan Lunas. Tersertifikasi dari Pos Anda.',
            'data'    => $transaction
        ]);
    }

    /**
     * Mengupdate status perjalanan rombongan
     * prepared -> on_track (Mulai Naik) -> finished (Udah Turun/Selesai)
     */
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:prepared,on_track,finished'
        ]);

        $admin = $request->user('admin') ?? $request->user();
        $transaction = Transaction::where('order_id', $orderId)->first();

        if (!$transaction || $transaction->status !== 'settlement') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tiket tidak valid atau belum lunas.'
            ], 400);
        }

        $hikingSession = HikingSession::where('transaction_id', $transaction->id)->first();
        
        if (!$hikingSession) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Detail pendakian tidak ditemukan.'
            ], 404);
        }

        // --- VALIDASI WEWENANG POS PENJAGAAN ADMIN ---
        if ($admin && $admin->role === 'basecamp_staff' && $admin->route_id) {
            if ($admin->route_id !== $hikingSession->route_id) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Akses Ditolak: Anda tidak memiliki wewenang untuk jalur pendakian ini.'
                ], 403);
            }
        }

        $currentStatus = $hikingSession->status;
        $newStatus = $request->status;

        // Validasi Alur Logika
        if ($currentStatus === 'finished' && $newStatus !== 'finished') {
            // Superadmin mungkin boleh mengubah (Misal jika salah pencet), tapi basecamp_staff tidak boleh gampang mengubah balik data yang udah 'selesai'.
            if ($admin && $admin->role === 'basecamp_staff') {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Rombongan ini sudah ditandai turun (finished). Anda tidak bisa mengulangi status pendakian.'
                ], 422);
            }
        }

        $hikingSession->status = $newStatus;
        $hikingSession->save();

        // Pesan Sukses yang dinamis sesuai status
        $msg = "Status rombongan berhasil di-update: {$newStatus}";
        if ($newStatus === 'on_track') {
            $msg = "Rombongan telah Check-in di Pos Anda dan mulai mendaki gunung.";
        } elseif ($newStatus === 'finished') {
            $msg = "Rombongan telah Check-out di Pos Anda dan kembali dengan selamat.";
        }

        return response()->json([
            'status'  => 'success',
            'message' => $msg,
            'data'    => $hikingSession
        ]);
    }
}
