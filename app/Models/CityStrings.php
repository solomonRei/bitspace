<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CityStrings extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = 'cities_strings';
    protected $fillable = [
        'name',
        'lang_id'
    ];

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'lang_id');
    }

    public function getLanguageCodeAttribute()
    {   
        return Str::upper($this->language->name);
    }
}
