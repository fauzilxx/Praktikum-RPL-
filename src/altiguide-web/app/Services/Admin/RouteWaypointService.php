<?php

namespace App\Services\Admin;

use App\Models\Route;
use App\Models\RouteWaypoint;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\UploadedFile;

class RouteWaypointService
{
    use HandlesImageUpload;

    public function createWaypoint(array $data, Route $route, ?UploadedFile $imageFile): RouteWaypoint
    {
        $data['route_id'] = $route->id;

        if ($imageFile) {
            $data['image'] = $this->uploadImage($imageFile, 'waypoints', $data['name']);
        }
        
        return RouteWaypoint::create($data);
    }

    public function updateWaypoint(RouteWaypoint $waypoint, array $data, ?UploadedFile $imageFile): RouteWaypoint
    {
        if ($imageFile) {
            $this->deleteImage($waypoint->image);
            $data['image'] = $this->uploadImage($imageFile, 'waypoints', $data['name']);
        }

        $waypoint->update($data);
        return $waypoint;
    }

    public function deleteWaypoint(RouteWaypoint $waypoint): bool
    {
        $this->deleteImage($waypoint->image);
        return $waypoint->delete();
    }
}