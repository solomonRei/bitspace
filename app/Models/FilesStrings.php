<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesStrings extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'files_strings';

    protected $fillable = [
        'file_id',
        'lang_id',
        'filename',
        'filename_full',
        'desc',
    ];
}
