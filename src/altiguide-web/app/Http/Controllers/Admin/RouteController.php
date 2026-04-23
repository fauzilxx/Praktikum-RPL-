<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use App\Models\Route as RouteModel;
use App\Http\Requests\Admin\RouteRequest;
use App\Services\Admin\RouteService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RouteController extends Controller
{
    private RouteService $routeService;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    /**
     * Tampilkan formulir tambah rute untuk gunung tertentu
     */
    public function create(Mountain $mountain)
    {
        return Inertia::render('Admin/Routes/Create', [
            'mountain' => $mountain
        ]);
    }

    /**
     * Menyimpan data rute
     */
    public function store(RouteRequest $request, Mountain $mountain)
    {
        $this->routeService->createRoute(
            $request->validated(),
            $mountain,
            auth('admin')->id(),
            $request->file('image')
        );

        return redirect()->route('admin.mountains.show', $mountain)
                         ->with('status', 'Rute berhasil ditambahkan.');
    }

    /**
     * Tampilkan formulir edit rute
     */
    public function edit(Mountain $mountain, RouteModel $route)
    {
        return Inertia::render('Admin/Routes/Edit', [
            'mountain' => $mountain,
            'route'    => $route
        ]);
    }

    /**
     * Memperbarui rute
     */
    public function update(RouteRequest $request, Mountain $mountain, RouteModel $route)
    {
        $this->routeService->updateRoute(
            $route, 
            $request->validated(), 
            $request->file('image')
        );

        return redirect()->route('admin.mountains.show', $mountain)
                         ->with('status', 'Rute berhasil diperbarui.');
    }

    /**
     * Menghapus rute
     */
    public function destroy(Mountain $mountain, RouteModel $route)
    {
        $this->routeService->deleteRoute($route);

        return redirect()->route('admin.mountains.show', $mountain)
                         ->with('status', 'Rute berhasil dihapus.');
    }
}