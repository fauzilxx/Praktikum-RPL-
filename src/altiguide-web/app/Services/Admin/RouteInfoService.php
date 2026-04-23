<?php

namespace App\Services\Admin;

use App\Models\Route;
use App\Models\RouteInfo;

class RouteInfoService
{
    /**
     * Memperbarui atau menyimpan data Route Info
     * (karena info rute hanya ada 1 per rute: HasOne)
     */
    public function upsertRouteInfo(Route $route, array $data): RouteInfo
    {
        return RouteInfo::updateOrCreate(
            ['route_id' => $route->id],
            $data
        );
    }
}