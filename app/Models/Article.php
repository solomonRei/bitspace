<?php

namespace App\Models;

use App\Traits\Languages;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use CrudTrait, Languages;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'blogs';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'in_main',
        'hits',
        'user'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!backpack_user()->id) return false;
        
            $model->setAttribute('user_id', backpack_user()->id);
        });
    }

    public function contentByLang(int $lang_id = null)
    {
        if ($lang_id === null) {
            $lang_id = $this->getLangId();
        }

        return $this->contents()->where('lang_id', $lang_id)->first();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contents()
    {
        return $this->hasMany(ArticleContent::class, 'blog_id');
    }

    public function image()
    {
        return $this->hasOneThrough(File::class, ArticlePhoto::class, 'blog_id', 'id', 'id', 'file_id');
    }

    public function photos()
    {
        return $this->hasMany(ArticlePhoto::class, 'blog_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tags', 'blog_id', 'tag_id');
    }

    public function tagsByLang()
    {
        return $this->tags()->where('lang_id', $this->getLangId());
    }

    public function content()
    {
        return $this->hasOne(ArticleContent::class, 'blog_id')->where('lang_id', $this->getLangId());
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByTagSlug(string $slug, Builder $query)
    {

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
