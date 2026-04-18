<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Get all routes with their info.
     */
    public function index()
    {
        // Dapat dikembalikan sebagai JSON atau response Inertia nantinya
        $routes = \App\Models\Route::with(['mountain', 'routeInfo'])->get();
        return response()->json($routes);
    }

    /**
     * Store a newly created route in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mountain_id' => 'required|exists:mountains,id',
            'name' => 'required|string|max:100',
            'distance' => 'required|numeric',
            'estimated_time' => 'required|integer',
            'difficulty' => 'required|in:easy,moderate,hard',
            'is_active' => 'boolean',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            
            // Route Info Payload
            'route_info.basecamp_address' => 'nullable|string',
            'route_info.basecamp_altitude' => 'nullable|integer',
            'route_info.simaksi_price' => 'nullable|numeric',
            'route_info.facilities_description' => 'nullable|string',
            'route_info.logistics_description' => 'nullable|string',

            // Waypoints Payload
            'waypoints' => 'nullable|array',
            'waypoints.*.name' => 'required|string|max:150',
            'waypoints.*.altitude' => 'nullable|integer',
            'waypoints.*.distance_from_prev' => 'nullable|numeric',
            'waypoints.*.estimated_time_minutes' => 'nullable|integer',
            'waypoints.*.description' => 'nullable|string',
            'waypoints.*.has_water_source' => 'boolean',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // 1. Buat Data Route Induk
            $route = \App\Models\Route::create($validated);

            // 2. Buat Route Info
            if (!empty($validated['route_info'])) {
                $route->routeInfo()->create($validated['route_info']);
            }

            // 3. Buat Data Pos/Waypoints yang berkelanjutan
            if (!empty($validated['waypoints'])) {
                foreach ($validated['waypoints'] as $index => $wp) {
                    $wp['order_index'] = $index + 1; // Atur urutan otomatis berdasar posisi array FE
                    $route->waypoints()->create($wp);
                }
            }

            \Illuminate\Support\Facades\DB::commit();
            return response()->json(['message' => 'Berhasil membuat Rute!', 'route' => $route->load('routeInfo', 'waypoints')], 201);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['message' => 'Gagal membuat Rute', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified route.
     */
    public function show($id)
    {
        $route = \App\Models\Route::with(['mountain', 'routeInfo', 'waypoints'])->findOrFail($id);
        return response()->json($route);
    }

    /**
     * Update the specified route in storage.
     */
    public function update(Request $request, $id)
    {
        $route = \App\Models\Route::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'distance' => 'sometimes|required|numeric',
            'estimated_time' => 'sometimes|required|integer',
            'difficulty' => 'sometimes|required|in:easy,moderate,hard',
            'is_active' => 'boolean',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            
            // Route Info Payload
            'route_info' => 'nullable|array',
            'route_info.basecamp_address' => 'nullable|string',
            'route_info.basecamp_altitude' => 'nullable|integer',
            'route_info.simaksi_price' => 'nullable|numeric',
            'route_info.facilities_description' => 'nullable|string',
            'route_info.logistics_description' => 'nullable|string',

            // Waypoints Payload
            'waypoints' => 'nullable|array',
            'waypoints.*.name' => 'required_with:waypoints|string|max:150',
            'waypoints.*.altitude' => 'nullable|integer',
            'waypoints.*.distance_from_prev' => 'nullable|numeric',
            'waypoints.*.estimated_time_minutes' => 'nullable|integer',
            'waypoints.*.description' => 'nullable|string',
            'waypoints.*.has_water_source' => 'boolean',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Update Rute Utama
            $route->update($validated);

            // Update atau Buat Info Rute
            if (isset($validated['route_info'])) {
                $route->routeInfo()->updateOrCreate(
                    ['route_id' => $route->id],
                    $validated['route_info']
                );
            }

            // Sync Waypoints (Hapus yang lama dan ganti semua inputan baru, 
            // berguna untuk FE dynamic array forms tanpa pusing cek mana yang didelete)
            if (isset($validated['waypoints'])) {
                $route->waypoints()->delete();
                
                foreach ($validated['waypoints'] as $index => $wp) {
                    $wp['order_index'] = $index + 1;
                    $route->waypoints()->create($wp);
                }
            }

            \Illuminate\Support\Facades\DB::commit();
            return response()->json(['message' => 'Berhasil mengupdate Rute!', 'route' => $route->load('routeInfo', 'waypoints')]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['message' => 'Gagal mengupdate Rute', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified route from storage.
     */
    public function destroy($id)
    {
        $route = \App\Models\Route::findOrFail($id);
        
        // Hapus Route (Waypoints dan route_info otomatis ikut terhapus karena onDelete cascade di migration)
        $route->delete(); 

        return response()->json(['message' => 'Rute berhasil dihapus!']);
    }
}
