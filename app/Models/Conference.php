<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id_owner', 'user_id', 'date_of_lesson', 'type', 'link', 'join_url', 'password'
    ];
}
