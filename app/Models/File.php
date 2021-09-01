<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory, SoftDeletes;

    public $file;

    protected $fillable = [
        'name',
        'filename',
        'file_path',
        'user_id'
    ];

    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            Storage::disk('public_folder')->delete($obj->file_path);
        });
    }

    public function fileStrings()
    {
        return $this->hasMany(\App\Models\FilesStrings::class, 'file_id');
    }
}
