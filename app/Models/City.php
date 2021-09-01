<?php

namespace App\Models;

use App\Traits\Languages;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory, CrudTrait, Languages;

    public $timestamps = false;

    protected $fillable = [
        'cityStrings.name',
        'cityStrings.lang_id',
    ];

    public function cityStrings()
    {
        return $this->hasMany(\App\Models\CityStrings::class, 'city_id');
    }

    public function stringByLang(int $lang_id = null)
    {
        if ($lang_id === null) {
            $lang_id = $this->getLangId();
        }

        return $this->cityStrings()->where('lang_id', $lang_id)->first();
    }

    public function cityStringsByLang(int $lang_id = null)
    {
        if ($lang_id === null) {
            $lang_id = $this->getLangId();
        }

        return $this->hasOne(CityStrings::class, 'city_id')->where('lang_id', $lang_id);
    }

    public static function list()
    {
        return self::with('cityStringsByLang')
            ->get()
            ->keyBy('id')
            ->pluck('cityStringsByLang.name', 'id')
            ->toArray();
    }
}
