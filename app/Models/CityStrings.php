<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityStrings extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = 'cities_strings';
}
