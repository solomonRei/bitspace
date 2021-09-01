<?php

namespace App\Models;

use App\Traits\Languages;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use CrudTrait, Languages;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tags_strings';
    // protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'lang_id',
        'name',
        'slug'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function setSlugAttribute($value = null)
    {
        if (!$this->exists || ($value && $value !== $this->getOriginal('slug'))) {
            $this->attributes['slug'] = $value ? Str::slug($value) : Str::slug($this->name);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'blog_tags', 'tag_id', 'blog_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang_id', 'id')->visible();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeByLang($query, int $lang_id = null)
    {
        if ($lang_id === null) {
            $lang_id = $this->getLangId();
        }
        return $query->where('lang_id', $lang_id);
    }

    public function scopeWithArticles($query)
    {
        return $query->having('articles_count', '>', 0);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
