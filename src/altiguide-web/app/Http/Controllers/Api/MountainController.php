<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class MountainController extends Controller
{
    /**
     * List semua gunung beserta rute-rutenya.
     */
    public function index()
    {
        $mountains = Mountain::with([
            'routes' => function ($query) {
                $query->select([
                    'id',
                    'mountain_id',
                    'name',
                    'slug',
                    'difficulty',
                    'distance',
                    'estimated_time',
                    'daily_quota',
                    'latitude',
                    'longitude',
                    'is_active',
                    'image'
                ]);
            },
            'routes.routeInfo'
        ])
        ->select([
            'id',
            'name',
            'slug',
            'altitude',
            'latitude',
            'longitude',
            'description',
            'image',
            'status'
        ])
        ->where('status', 'open')
        ->get();

        return response()->json($mountains);
    }

    /**
     * Detail satu gunung beserta rute, info rute, dan waypoints.
     */
    public function show($id)
    {
        $mountain = Mountain::with([
            'routes' => function ($query) {
                $query->select([
                    'id',
                    'mountain_id',
                    'name',
                    'slug',
                    'difficulty',
                    'distance',
                    'estimated_time',
                    'daily_quota',
                    'latitude',
                    'longitude',
                    'is_active',
                    'image',
                    'track_coordinates'
                ]);
            },
            'routes.routeInfo',
            'routes.waypoints' => function ($query) {
                $query->orderBy('order_index', 'asc');
            }
        ])
        ->findOrFail($id);

        return response()->json($mountain);
    }

    /**
     * Mendapatkan data cuaca terkini dari Open-Meteo untuk gunung tertentu.
     */
    public function weather($id)
    {
        $mountain = Mountain::findOrFail($id);

        if (!$mountain->latitude || !$mountain->longitude) {
            return response()->json([
                'status' => 'error',
                'message' => 'Koordinat gunung belum disetel di database.'
            ], 400);
        }

        try {
            $response = Http::get('https://api.open-meteo.com/v1/forecast', [
                'latitude'        => $mountain->latitude,
                'longitude'       => $mountain->longitude,
                'elevation'       => $mountain->altitude, // Koreksi suhu berdasarkan mdpl
                'current_weather' => 'true',
                'daily'           => 'temperature_2m_max,temperature_2m_min,weathercode',
                'timezone'        => 'Asia/Jakarta'
            ]);

            if ($response->successful()) {
                return response()->json([
                    'status'        => 'success',
                    'mountain_name' => $mountain->name,
                    'data'          => $response->json()
                ]);
            }

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengambil data dari server cuaca.'
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan sistem saat menghubungi server cuaca.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
