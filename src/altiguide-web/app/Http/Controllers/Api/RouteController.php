<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class RouteController extends Controller
{
    /**
     * List semua rute beserta gunung dan info rute.
     */
    public function index()
    {
        $routes = Route::with(['mountain', 'routeInfo'])->get();

        return response()->json($routes);
    }

    /**
     * Detail satu rute beserta gunung, info rute, dan waypoints.
     */
    public function show($id)
    {
        $route = Route::with(['mountain', 'routeInfo', 'waypoints'])->findOrFail($id);

        return response()->json($route);
    }

    /**
     * Mendapatkan data cuaca terkini dari Open-Meteo untuk Basecamp rute tertentu.
     */
    public function weather($id)
    {
        $route = Route::with('routeInfo')->findOrFail($id);

        if (!$route->latitude || !$route->longitude) {
            return response()->json([
                'status' => 'error',
                'message' => 'Koordinat basecamp rute belum disetel di database.'
            ], 400);
        }

        // Ambil ketinggian basecamp dari tabel route_info (default ke 1000 jika kosong)
        $elevation = $route->routeInfo && $route->routeInfo->basecamp_altitude 
            ? $route->routeInfo->basecamp_altitude 
            : 1000;

        try {
            $response = Http::get('https://api.open-meteo.com/v1/forecast', [
                'latitude'        => $route->latitude,
                'longitude'       => $route->longitude,
                'elevation'       => $elevation,
                'current_weather' => 'true',
                'daily'           => 'temperature_2m_max,temperature_2m_min,weathercode',
                'timezone'        => 'Asia/Jakarta'
            ]);

            if ($response->successful()) {
                return response()->json([
                    'status'            => 'success',
                    'route_name'        => $route->name,
                    'basecamp_altitude' => $elevation,
                    'data'              => $response->json()
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
