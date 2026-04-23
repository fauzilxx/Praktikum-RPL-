<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mountain extends Model
{
    use \App\Traits\HasSlug;

    protected $fillable = [
        'name',
        'slug',
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
