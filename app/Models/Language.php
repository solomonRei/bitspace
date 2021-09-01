<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Backpack\CRUD\app\Models\Traits\CrudTrait;

class Language extends Model
{
    use HasFactory, CrudTrait;

    public $timestamps = false;

    public function scopeVisible($query)
    {
        return $query->where('visible', 1);
    }

}
