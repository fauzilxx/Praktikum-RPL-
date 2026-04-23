<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Http\Requests\Admin\RouteInfoRequest;
use App\Services\Admin\RouteInfoService;
use Inertia\Inertia;

class RouteInfoController extends Controller
{
    private RouteInfoService $routeInfoService;

    public function __construct(RouteInfoService $routeInfoService)
    {
        $this->routeInfoService = $routeInfoService;
    }

    /**
     * Tampilkan halaman kelola Informasi Rute Tambahan
     */
    public function edit(Route $route)
    {
        $route->load('routeInfo', 'mountain');
        
        return Inertia::render('Admin/RouteInfos/Edit', [
            'route'     => $route,
            'routeInfo' => $route->routeInfo // Null jika belum ada data info
        ]);
    }

    /**
     * Menyimpan atau Update Informasi Rute
     */
    public function update(RouteInfoRequest $request, Route $route)
    {
        $this->routeInfoService->upsertRouteInfo($route, $request->validated());

        return redirect()->route('admin.mountains.show', $route->mountain_id)
                         ->with('status', 'Informasi ekstra lintasan rute berhasil disimpan.');
    }
}