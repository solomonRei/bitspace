<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, CrudTrait;
    public $timestamps = false;

    public function categoryStrings()
    {
        return $this->hasMany(\App\Models\CategoryStrings::class, 'category_id');
//        return $this->hasManyThrough(\App\Models\Language::class, \App\Models\CityStrings::class, 'city_id', 'id', 'id', 'lang_id');
    }

    public function userCategory()
    {
        return $this->hasMany(\App\Models\User::class, 'category_id');
    }

    public function getNameAttribute()
    {

        return isset($this->categoryStrings[0]->name) ? ucfirst($this->categoryStrings[0]->name) : '';
    }
}
