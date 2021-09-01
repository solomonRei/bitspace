<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GroupStrings extends Model
{
    use HasFactory;
    public $table = 'groups_strings';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'lang_id',
        'is_hidden',
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
