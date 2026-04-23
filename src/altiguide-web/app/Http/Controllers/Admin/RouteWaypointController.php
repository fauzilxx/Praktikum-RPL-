<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\RouteWaypoint;
use App\Http\Requests\Admin\RouteWaypointRequest;
use App\Services\Admin\RouteWaypointService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RouteWaypointController extends Controller
{
    private RouteWaypointService $waypointService;

    public function __construct(RouteWaypointService $waypointService)
    {
        $this->waypointService = $waypointService;
    }

    /**
     * Halaman Master Titik Singgah/Pos untuk spesifik rute (Read)
     */
    public function index(Route $route)
    {
        $route->load('mountain'); 
        
        $waypoints = RouteWaypoint::where('route_id', $route->id)
            ->orderBy('order_index', 'asc')
            ->get();

        return Inertia::render('Admin/Waypoints/Index', [
            'route'     => $route,
            'waypoints' => $waypoints
        ]);
    }

    /**
     * Tampilkan formulir tambah titik singgah (Pos)
     */
    public function create(Route $route)
    {
        return Inertia::render('Admin/Waypoints/Create', [
            'route' => $route
        ]);
    }

    /**
     * Menyimpan data titik singgah
     */
    public function store(RouteWaypointRequest $request, Route $route)
    {
        $this->waypointService->createWaypoint(
            $request->validated(),
            $route,
            $request->file('image')
        );

        return redirect()->route('admin.routes.waypoints.index', $route)
                         ->with('status', 'Titik Singgah / Pos berhasil ditambahkan.');
    }

    /**
     * Tampilkan formulir edit titik singgah
     */
    public function edit(Route $route, RouteWaypoint $waypoint)
    {
        return Inertia::render('Admin/Waypoints/Edit', [
            'route'    => $route,
            'waypoint' => $waypoint
        ]);
    }

    /**
     * Memperbarui data titik singgah
     */
    public function update(RouteWaypointRequest $request, Route $route, RouteWaypoint $waypoint)
    {
        $this->waypointService->updateWaypoint(
            $waypoint, 
            $request->validated(), 
            $request->file('image')
        );

        return redirect()->route('admin.routes.waypoints.index', $route)
                         ->with('status', 'Titik Singgah / Pos berhasil diperbarui.');
    }

    /**
     * Menghapus titik singgah
     */
    public function destroy(Route $route, RouteWaypoint $waypoint)
    {
        $this->waypointService->deleteWaypoint($waypoint);

        return redirect()->route('admin.routes.waypoints.index', $route)
                         ->with('status', 'Titik Singgah / Pos berhasil dihapus.');
    }
}
