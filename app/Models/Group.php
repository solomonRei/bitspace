<?php

namespace App\Models;

use App\Traits\Languages;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory, CrudTrait, Languages;

    public $timestamps = false;

    protected $fillable = [
        'is_hidden'
    ];

    public function groupStrings()
    {
        return $this->hasMany(\App\Models\GroupStrings::class, 'group_id');
    }

    public function groupStringsByLang(int $lang_id = null)
    {
        if ($lang_id === null) {
            $lang_id = $this->getLangId();
        }

        return $this->hasOne(\App\Models\GroupStrings::class, 'group_id')->where('lang_id', $lang_id);
    }

    public function scopeIsShowed($query)
    {
        return $query->where('is_hidden', 0);
    }

    public function stringByLang(int $lang_id = null)
    {
        if ($lang_id === null) {
            $lang_id = $this->getLangId();
        }

        return $this->groupStrings()->where('lang_id', $lang_id)->first();
    }

    public static function list()
    {
        return self::with('groupStringsByLang')
            ->isShowed()
            ->get()
            ->keyBy('id')
            ->pluck('groupStringsByLang.name', 'id')
            ->toArray();
    }
}
