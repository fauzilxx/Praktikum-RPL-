<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use Illuminate\Http\Request;

class MountainController extends Controller
{
    /**
     * List semua gunung beserta rute-rutenya.
     */
    public function index()
    {
        $mountains = Mountain::with('routes')->get();

        return response()->json($mountains);
    }

    /**
     * Detail satu gunung beserta rute, info rute, dan waypoints.
     */
    public function show($id)
    {
        $mountain = Mountain::with(['routes.routeInfo', 'routes.waypoints'])->findOrFail($id);

        return response()->json($mountain);
    }
}
