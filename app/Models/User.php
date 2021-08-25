<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Languages;
use App\Traits\File;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, Languages, File;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'ava',
        'email',
        'password',
        'phone',
        'surname',
        'is_hided',
        'is_searched'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'user_id');
    }

    public function category()
    {
        return $this->hasMany(\App\Models\Category::class, 'id', 'category_id');
    }

    public function categoryStrings()
    {
        return $this->hasMany(\App\Models\CategoryStrings::class, 'category_id', 'category_id');
    }

    public function group()
    {
        return $this->hasMany(\App\Models\Group::class, 'id', 'group_id');
    }

    public function userStrings()
    {
        return $this->hasMany(\App\Models\UsersStrings::class, 'user_id');
    }

    public function scopeIsSearched($query)
    {
        return $query->where('is_searched', 0);
    }

    public function scopeTeachers($query)
    {
        return $query->where('type', 0);
    }

    public function scopeIsHided($query)
    {
        return $query->where('is_hided', 0);
    }

    public function setIsHidedAttribute($value)
    {
        $this->attributes['is_hided'] = $value == 'on' ? 1 : 0;
    }


    public function setIsSearchedAttribute($value)
    {
        $this->attributes['is_searched'] = $value == 'on' ? 1 : 0;
    }

//    public function setNameAttribute($value)
//    {
//       if ($languages = $this->getLanguages()) {
//           foreach ($languages as $language) {
//               if (isset($value[$language->name]) && isset($this->attributes['surname'][$language->name])){
//                   $this->attributes['name'] = ucfirst($value[$language->name])." ".ucfirst($this->attributes['surname'][$language->name]);
//               }
//            }
//       }
//    }


}
