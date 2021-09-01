<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CategoryStrings extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = 'categories_strings';
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

    public function category()
    {
        return $this->belongsTo(Category::class, 'id', 'category_id');
    }
}
