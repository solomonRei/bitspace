<?php
namespace App\Traits;
use App\Models\File as Model;

trait File
{
    public function getFileById($id)
    {
        return Model::whereId($id)->first();
    }
}
