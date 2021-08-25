<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'start', 'end', 'type','conference_id'
    ];

    public function conference()
    {
        return $this->hasOne(\App\Models\Conference::class, 'id', 'conference_id');
    }
}
