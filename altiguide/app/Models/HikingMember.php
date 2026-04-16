<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class HikingMember extends Model
{
    use HasUuids;

    protected $fillable = [
        'hiking_session_id',
        'user_id',
        'identity_number',
        'full_name',
        'phone_number',
        'emergency_contact',
    ];

    public function hikingSession()
    {
        return $this->belongsTo(HikingSession::class, 'hiking_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
