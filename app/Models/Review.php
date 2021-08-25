<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    const ACTIVE = 1, IN_ACTIVE = 0;

    public function scopeApproved($query)
    {
        return $query->where('is_approved', self::ACTIVE);
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d M Y');
    }

    public function userStrings()
    {
        return $this->hasMany(\App\Models\UsersStrings::class, 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id', 'user_id');
    }

}
