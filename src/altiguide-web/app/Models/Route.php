<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'name',
        'distance',
        'estimated_time',
        'mountain_id',
        'difficulty',
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
}
