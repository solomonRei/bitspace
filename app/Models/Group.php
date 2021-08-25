<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function groupString()
    {
        return $this->hasMany(\App\Models\GroupStrings::class, 'group_id');
    }

    public function scopeIsShowed($query)
    {
        return $query->where('is_hidden', 0);
    }
}
