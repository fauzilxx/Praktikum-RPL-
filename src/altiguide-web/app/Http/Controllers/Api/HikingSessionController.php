<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HikingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HikingSessionController extends Controller
{
    /**
     * List semua sesi hiking milik user (sebagai leader).
     */
    public function index(Request $request)
    {
        $sessions = $request->user()
            ->hikingSessions()
            ->with(['route.mountain', 'members'])
            ->orderByDesc('created_at')
            ->get();

        return response()->json($sessions);
    }

    /**
     * Buat sesi hiking baru beserta anggota grup.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'route_id'       => ['required', 'exists:routes,id'],
            'transaction_id' => ['required', 'exists:transactions,id'],
            'group_name'     => ['required', 'string', 'max:100'],

            // Data anggota hiking
            'members'                    => ['nullable', 'array'],
            'members.*.identity_number'  => ['required_with:members', 'string', 'max:20'],
            'members.*.full_name'        => ['required_with:members', 'string', 'max:100'],
            'members.*.phone_number'     => ['required_with:members', 'string', 'max:15'],
            'members.*.emergency_contact'=> ['required_with:members', 'string', 'max:15'],
        ]);

        DB::beginTransaction();
        try {
            // Buat sesi hiking
            $session = HikingSession::create([
                'leader_id'      => $request->user()->id,
                'route_id'       => $validated['route_id'],
                'transaction_id' => $validated['transaction_id'],
                'group_name'     => $validated['group_name'],
                'status'         => 'registered',
            ]);

            // Tambahkan anggota grup
            if (! empty($validated['members'])) {
                foreach ($validated['members'] as $member) {
                    $session->members()->create([
                        'user_id'           => $request->user()->id,
                        'identity_number'   => $member['identity_number'],
                        'full_name'         => $member['full_name'],
                        'phone_number'      => $member['phone_number'],
                        'emergency_contact' => $member['emergency_contact'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Sesi hiking berhasil dibuat!',
                'session' => $session->load('members'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal membuat sesi hiking.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Detail sesi hiking beserta anggota (hanya milik user sendiri).
     */
    public function show(Request $request, $id)
    {
        $session = $request->user()
            ->hikingSessions()
            ->with(['route.mountain', 'route.routeInfo', 'route.waypoints', 'members', 'transaction'])
            ->findOrFail($id);

        return response()->json($session);
    }
}
