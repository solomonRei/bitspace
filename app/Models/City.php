<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function cityStrings()
    {
        return $this->hasMany(\App\Models\CityStrings::class, 'city_id');
//        return $this->hasManyThrough(\App\Models\Language::class, \App\Models\CityStrings::class, 'city_id', 'id', 'id', 'lang_id');
    }
}
