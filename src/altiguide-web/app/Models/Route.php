<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use \App\Traits\HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'distance',
        'estimated_time',
        'mountain_id',
        'difficulty',
        'image',
        'is_active',
        'latitude',
        'longitude',
    ];

    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function hikingSessions()
    {
        return $this->hasMany(HikingSession::class);
    }

    public function routeInfo()
    {
        return $this->hasOne(RouteInfo::class);
    }

    public function waypoints()
    {
        return $this->hasMany(RouteWaypoint::class)->orderBy('order_index', 'asc');
    }
}
