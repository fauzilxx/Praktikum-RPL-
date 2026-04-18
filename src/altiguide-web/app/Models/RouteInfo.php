<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteInfo extends Model
{
    protected $fillable = [
        'route_id',
        'basecamp_address',
        'basecamp_altitude',
        'simaksi_price',
        'facilities_description',
        'logistics_description',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
