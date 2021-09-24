<?php

namespace App\Models;

use App\Models\File as ModelsFile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Languages;
use App\Traits\File;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, Languages, File, CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'name',
        'ava',
        'email',
        'password',
        'phone',
        'surname',
        'is_hided',
        'is_searched',
        'api_token'
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

    public function stringByLang(int $lang_id = null)
    {
        if ($lang_id === null) {
            $lang_id = $this->getLangId();
        }

        return $this->hasOne(\App\Models\UsersStrings::class, 'user_id')
            ->where('lang_id', $lang_id)->first();
    }

    public function userStringsByLang()
    {
        return $this->hasOne(\App\Models\UsersStrings::class, 'user_id')
            ->where('lang_id', $this->getLangId());
    }

    public function avatar()
    {
        return $this->hasOne(ModelsFile::class, 'id', 'ava');
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function cityName()
    {
        return $this->hasOneThrough(CityStrings::class, City::class, 'id', 'city_id', 'city_id', 'id')
            ->where('lang_id', $this->getLangId());
    }

    public function categoryName()
    {
        return $this->hasOneThrough(CategoryStrings::class, Category::class, 'id', 'category_id', 'category_id', 'id')
            ->where('lang_id', $this->getLangId());
    }

    public function GroupName()
    {
        return $this->hasOneThrough(GroupStrings::class, Group::class, 'id', 'group_id', 'group_id', 'id')
            ->where('lang_id', $this->getLangId());
    }

    public function scopeIsSearched($query)
    {
        return $query->where('is_searched', 0);
    }

    public function scopeTeachers($query)
    {
        return $query->where('type', 0);
    }

    public function scopeIsShown($query)
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

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make(Str::random(10));
    }

    public function setApiTokenAttribute($value)
    {
        $this->attributes['api_token'] = Hash::make(Str::random(10));
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
