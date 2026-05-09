<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class HikingSession extends Model
{
    use HasUuids;

    protected $fillable = [
        'leader_id',
        'route_id',
        'transaction_id',
        'group_name',
        'start_date',
        'end_date',
        'hike_type',
        'status',
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function members()
    {
        return $this->hasMany(HikingMember::class, 'hiking_session_id');
    }
}