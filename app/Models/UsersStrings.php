<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\File;

class UsersStrings extends Model
{
    use HasFactory, File;
    public $timestamps = false;
    public $table = 'users_strings';

    protected $casts = [
        'directions' => 'array',
        'mediafiles_url' => 'array'
    ];

    protected $fillable = [
        'name',
        'surname',
        'lang_id',
        'education',
        'about',
        'age',
        'experience',
        'mediafiles_url'
    ];

    public function getUsersString($lang_id, $user_id)
    {
        return $this->where('lang_id', $lang_id)
            ->where('user_id', $user_id)
            ->first();
    }

    public function getDirectionsRawAttribute()
    {
        $directions = '';

        if (!empty($this->directions) && count($this->directions['data']) > 0) {
            foreach ($this->directions['data'] as $direction)
                $directions .= $direction.', ';

            $directions = rtrim($directions, ', ');
        }

        return $directions;
    }

    public function getAgeNameAttribute()
    {
        $value = $this->age;
        $words = ['год', 'года', 'лет'];

        $value = $value % 100;
        if ($value > 19) {
            $value = $value % 10;
        }
        switch ($value) {
            case 1: {
                return($words[0]);
            }
            case 2: case 3: case 4: {
                return($words[1]);
        }
            default: {
                return($words[2]);
            }
        }
    }

    public function getAboutCutAttribute()
    {
            $text = $this->about;
            $str = Str::words($text, 30, '');
            $str_1 = Str::ucfirst(trim(mb_substr($text, Str::length($str), Str::length($text))));
        return [$str, $str_1];
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function setMediafilesUrlAttribute($value)
    {
        $this->attributes['mediafiles_url'] = json_encode($value);
    }


}
