<?php

namespace App\Models;

use App\Traits\Languages;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, CrudTrait, Languages;

    public $timestamps = false;

    protected $fillable = [
        'categoryStrings.name',
        'categoryStrings.lang_id',
    ];

    public function categoryStrings()
    {
        return $this->hasMany(\App\Models\CategoryStrings::class, 'category_id');
    }

    public function userCategory()
    {
        return $this->hasMany(\App\Models\User::class, 'category_id');
    }

    public function getNameAttribute()
    {

        return isset($this->categoryStrings[0]->name) ? ucfirst($this->categoryStrings[0]->name) : '';
    }

    public function stringByLang(int $lang_id = null)
    {
        if ($lang_id === null) {
            $lang_id = $this->getLangId();
        }

        return $this->categoryStrings()->where('lang_id', $lang_id)->first();
    }
}
