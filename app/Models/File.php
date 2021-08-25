<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'filename',
        'file_path'
    ];

    public function fileStrings()
    {
        return $this->hasMany(\App\Models\FilesStrings::class, 'file_id');
    }
}
