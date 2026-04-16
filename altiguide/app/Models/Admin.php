<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasUuids;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'route_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ──── Relationships ────

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    /**
     * Gunung yang dibuat oleh admin ini.
     */
    public function createdMountains()
    {
        return $this->hasMany(Mountain::class, 'created_by');
    }

    /**
     * Akses gunung via rute yang ditugaskan (untuk basecamp_staff).
     */
    public function mountain()
    {
        return $this->hasOneThrough(Mountain::class, Route::class, 'id', 'id', 'route_id', 'mountain_id');
    }
}
