<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\HikingSession;
use App\Models\HikingMember;
use App\Models\Route;
use App\Models\RouteInfo;
use App\Jobs\SendETicketJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function __construct()
    {
        // Konfigurasi dasar Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-YOUR_KEY_HERE'); 
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * List semua transaksi milik user yang sedang login.
     * Modifikasi: Relasikan data Gunung/Rute, agar bisa digambar cantik di UI HP/Web.
     */
    public function index(Request $request)
    {
        $transactions = $request->user()
            ->transactions()
            ->with([
                'hikingSession.route.mountain', // Supaya frontend tau nama gunung dan rute
                'hikingSession.members:id,hiking_session_id' // Minimal untuk tahu jumlah total member per transaksi
            ])
            ->orderByDesc('created_at')
            ->get();

        // Modifikasi Data yang dikirim (jika diperlukan) atau return secara langsung
        return response()->json([
            'status' => 'success',
            'data'   => $transactions
        ]);
    }

    /**
     * EKSEKUSI MESIN CHECKOUT & PEMBUATAN SNAP TOKEN MIDTRANS
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id'                     => 'required|exists:routes,id',
            'start_date'                   => 'required|date|after_or_equal:today',
            'hike_type'                    => 'required|in:tektok,camp',
            'group_name'                   => 'required|string|max:100',
            'members'                      => 'required|array|min:1|max:10',
            'members.*.user_id'            => 'required|exists:users,id',
            'members.*.identity_number'    => 'required|string|size:16',
            'members.*.full_name'          => 'required|string|max:100',
            'members.*.phone_number'       => 'required|string|max:15',
            'members.*.emergency_contact'  => 'required|string|max:15',
        ]);

        $route = Route::with(['routeInfo', 'mountain'])->findOrFail($request->route_id);
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        
        $endDate = ($request->hike_type === 'camp') 
                   ? $startDate->copy()->addDay()->endOfDay() 
                   : $startDate->copy()->endOfDay();

        $totalMembers = count($request->members);

        // Pengecekan Kuota
        $bookedCount = HikingMember::whereHas('hikingSession', function($query) use ($route, $startDate) {
            $query->where('route_id', $route->id)
                  ->whereDate('start_date', $startDate)
                  ->whereHas('transaction', function($qTx) {
                      $qTx->whereIn('status', ['pending', 'settlement']);
                  });
        })->count();

        $remainingQuota = $route->daily_quota - $bookedCount;

        if ($remainingQuota < $totalMembers) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Maaf, sisa kuota untuk rute pada tanggal tersebut tidak mencukupi.',
            ], 422);
        }

        // Kalkulasi Biaya
        $simaksiPrice = $route->routeInfo->simaksi_price ?? 0;
        $applicationFee = 5000;
        $grossAmount = ($simaksiPrice * $totalMembers) + ($applicationFee * $totalMembers);

        DB::beginTransaction();

        try {
            $orderId = 'ALT-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Siapkan Parameter Midtrans
            $midtransParams = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => $grossAmount,
                ],
                'customer_details' => [
                    'first_name' => $request->user()->name,
                    'phone'      => $request->user()->phone_number,
                ],
                'item_details' => [
                    [
                        'id'       => 'TIKET',
                        'price'    => $simaksiPrice,
                        'quantity' => $totalMembers,
                        'name'     => 'Simaksi ' . $route->mountain->name,
                    ],
                    [
                        'id'       => 'FEE',
                        'price'    => $applicationFee,
                        'quantity' => $totalMembers,
                        'name'     => 'Biaya Layanan AltiGuide',
                    ]
                ],
                // Kita kunci ke QRIS karena sesuai desain UI (payment methodnya hanya qris)
                'enabled_payments' => ['gopay', 'shopeepay', 'other_qris'], 
            ];

            // Tembak API Midtrans untuk dapatkan Snap Payment URL
            $snapTransaction = Snap::createTransaction($midtransParams);
            $paymentUrl = $snapTransaction->redirect_url;
            $snapToken = $snapTransaction->token;

            $transaction = Transaction::create([
                'user_id'      => $request->user()->id,
                'order_id'     => $orderId,
                'gross_amount' => $grossAmount,
                'status'       => 'pending',
                'payment_type' => 'qris',
                'qr_url'       => $paymentUrl, // Di tabel transaksi Anda pakai text('qr_url')
                'expiry_time'  => Carbon::now()->addHour() // Expiry 1 Jam
            ]);

            $hikingSession = HikingSession::create([
                'leader_id'      => $request->user()->id,
                'route_id'       => $route->id,
                'transaction_id' => $transaction->id,
                'group_name'     => $request->group_name,
                'start_date'     => $startDate,
                'end_date'       => $endDate,
                'hike_type'      => $request->hike_type,
                'status'         => 'prepared'
            ]);

            foreach ($request->members as $memberData) {
                HikingMember::create([
                    'hiking_session_id' => $hikingSession->id,
                    'user_id'           => $memberData['user_id'],
                    'identity_number'   => $memberData['identity_number'],
                    'full_name'         => $memberData['full_name'],
                    'phone_number'      => $memberData['phone_number'],
                    'emergency_contact' => $memberData['emergency_contact']
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Pesanan berhasil dibuat. Lakukan pembayaran via QRIS.',
                'data'    => [
                    'order_id'     => $transaction->order_id,
                    'gross_amount' => $transaction->gross_amount,
                    'payment_url'  => $paymentUrl,
                    'snap_token'   => $snapToken,
                    'expiry_time'  => $transaction->expiry_time,
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan sistem saat menghubungi Midtrans.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Webhook/Callback untuk menerima notifikasi dari server Midtrans (Otomatis).
     */
    public function callback(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . Config::$serverKey);

        if ($notification->signature_key != $validSignatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaction::where('order_id', $notification->order_id)->first();
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;

        if ($status == 'capture' || $status == 'settlement') {
            // Cegah pengiriman email dobel jika Midtrans terpaksa mengirim notifikasi ulang
            $isAlreadySettled = $transaction->status === 'settlement';
            
            $transaction->status = 'settlement';
            $transaction->payment_type = $type;

            // Jika ini pertama kalinya lunas, lemparkan tugas ke Queue Worker (Background)
            if (!$isAlreadySettled) {
                dispatch(new SendETicketJob($transaction));
            }
        } else if ($status == 'cancel' || $status == 'deny' || $status == 'expire') {
            $transaction->status = 'expire';
            
            // JIKA EXPIRED -> BATAL -> KITA BATALKAN JUGA SESI PENDAKIANNYA
            $hikingSession = HikingSession::where('transaction_id', $transaction->id)->first();
            if ($hikingSession) {
                // Supaya kuota dikembalikan, kita bisa ubah statusnya atau menghapusnya.
                // Untuk riwayat yang bersih, biarkan transaksi ada namun status session dibatalkan.
                // Namun karena tabel hiking_sessions hanya punya status Enum ('prepared', 'on_track', 'finished'), 
                // secara logis dia tidak akan dihitung di query booking jika transaction status-nya "expire".
            }
        } else if ($status == 'pending') {
            $transaction->status = 'pending';
        }

        $transaction->transaction_id = $notification->transaction_id;
        $transaction->save();

        return response()->json(['message' => 'Status updated successfully.']);
    }

    /**
     * Detail transaksi (hanya milik user sendiri).
     */
    public function show(Request $request, $id)
    {
        $transaction = $request->user()
            ->transactions()
            ->with(['hikingSession.route.mountain', 'hikingSession.members'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data'   => $transaction
        ]);
    }

    /**
     * Generate PDF untuk E-Ticket berdasarkan Transaction ID.
     */
    public function downloadPdf(Request $request, $id)
    {
        // 1. Validasi Pemilik dan Status
        // Kita hanya mencari transaksi yang merupakan milik user yang login.
        $transaction = $request->user()
            ->transactions()
            ->with([
                'user',
                'hikingSession.route.mountain',
                'hikingSession.members'
            ])
            ->findOrFail($id);

        // 2. Validasi Pembayaran
        if ($transaction->status !== 'settlement') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tiket PDF hanya dapat diakses untuk transaksi yang sudah dilunasi.'
            ], 403);
        }

        // 3. Render View ke PDF menggunakan DomPDF. 
        // File view yang digunakan adalah resources/views/pdf/eticket.blade.php
        $pdf = Pdf::loadView('pdf.eticket', ['transaction' => $transaction]);

        // 4. Return Output via Download
        $filename = 'E-Ticket-' . $transaction->order_id . '.pdf';
        
        // Jika ingin PDF langsung tampil di browser (Inline mode), ganti download() dengan stream()
        return $pdf->stream($filename);
    }
}
