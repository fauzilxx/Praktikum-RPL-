<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteWaypoint extends Model
{
    use \App\Traits\HasSlug;

    protected $fillable = [
        'route_id',
        'name',
        'slug',
        'altitude',
        'order_index',
        'distance_from_prev',
        'estimated_time_minutes',
        'description',
        'image',
        'has_water_source',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
