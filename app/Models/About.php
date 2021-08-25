<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory, CrudTrait;

    public $timestamps = false;
    public $table = 'about';

    protected $fillable = [
      'text',
      'lang_id',
      'link'
    ];
}
