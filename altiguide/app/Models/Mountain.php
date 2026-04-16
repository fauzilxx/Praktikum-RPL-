<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mountain extends Model
{
    protected $fillable = [
        'name',
        'location',
        'altitude',
        'description',
        'latitude',
        'longitude',
        'image',
        'status',
        'created_by'
    ];

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
