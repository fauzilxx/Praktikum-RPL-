<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\HikingMember;
use App\Models\HikingSession;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MemberValidationController extends Controller
{
    /**
     * Memvalidasi NIK anggota untuk proses booking.
     * Mengecek ketersediaan akun dan memastikan tidak ada pendakian ganda.
     */
    public function validateNik(Request $request)
    {
        $request->validate([
            'nik'        => 'required|string|size:16',
            'start_date' => 'required|date|after_or_equal:today',
            'hike_type'  => 'required|in:tektok,camp',
        ]);

        $nik = $request->nik;
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        
        // 0. Otomatisasi End Date berdasarkan Hike Type
        // Jika camp = 2 Hari 1 Malam (+1 hari), jika tektok = Selesai di hari yang sama
        if ($request->hike_type === 'camp') {
            $endDate = $startDate->copy()->addDay()->endOfDay();
        } else {
            $endDate = $startDate->copy()->endOfDay();
        }

        // 1. Lapis Pertama: Cek apakah user dengan NIK tersebut ada di database kita
        $user = User::where('nik', $nik)->first();

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'NIK tidak terdaftar! Pastikan anggota ini sudah mendownload aplikasi dan mendaftar akun AltiGuide.'
            ], 404);
        }

        // 2. Lapis Kedua: Anti-Double Booking (Mengecek tanggal bentrok)
        // Kita periksa session pendakian di mana statusnya 'prepared' atau 'on_track'
        $isOverlapping = HikingMember::where('user_id', $user->id)
            ->whereHas('hikingSession', function ($query) use ($startDate, $endDate) {
                // Jangan cek jika session sudah finish/batal
                $query->whereIn('status', ['prepared', 'on_track'])
                      ->where(function ($q) use ($startDate, $endDate) {
                          $q->whereBetween('start_date', [$startDate, $endDate])
                            ->orWhereBetween('end_date', [$startDate, $endDate])
                            ->orWhere(function ($subQ) use ($startDate, $endDate) {
                                // Kasus jika jadwal baru berada di TENGAH-TENGAH jadwal lama
                                $subQ->where('start_date', '<=', $startDate)
                                     ->where('end_date', '>=', $endDate);
                            });
                      });
            })->exists();

        // Tambahan: Kita juga cek Jika dia ketua ('leader') dari grup yang belum selesai
        $isLeaderOverlapping = HikingSession::where('leader_id', $user->id)
             ->whereIn('status', ['prepared', 'on_track'])
             ->where(function ($q) use ($startDate, $endDate) {
                  $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($subQ) use ($startDate, $endDate) {
                        $subQ->where('start_date', '<=', $startDate)
                             ->where('end_date', '>=', $endDate);
                    });
             })->exists();

        if ($isOverlapping || $isLeaderOverlapping) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Anggota ('.$user->name.') sudah memiliki jadwal pendakian aktif pada tanggal tersebut! Pendakian serentak tidak diizinkan demi keselamatan.'
            ], 422); // 422 Unprocessable Entity
        }

        // 3. Lolos Validasi! Kembalikan data aslinya untuk auto-fill di Frontend
        return response()->json([
            'status'  => 'success',
            'message' => 'NIK Valid dan siap ditambahkan ke rombongan.',
            'data'    => [
                'user_id'           => $user->id,
                'nik'               => $user->nik,
                'full_name'         => $user->name,
                'phone_number'      => $user->phone_number,
                'emergency_contact' => $user->emergency_contact,
            ]
        ], 200);
    }
}
