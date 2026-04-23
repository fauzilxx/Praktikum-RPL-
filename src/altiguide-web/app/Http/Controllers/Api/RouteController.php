<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

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
}
