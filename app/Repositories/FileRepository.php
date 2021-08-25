<?php
namespace App\Repositories;

use App\Models\City;
use App\Traits\Languages;
use App\Models\File;

class FileRepository
{
    use Languages;

    public function getByUserId($id, $type, $count = 10)
    {
        return File::where('user_id', $id)
            ->where('type', $type)
            ->limit($count)
            ->get();
    }

    public function getById($id)
    {
        return File::find($id);
    }

    public function getByUserAndId($id, $user_id)
    {
        return File::where('user_id', $user_id)->where('id', $id);
    }

    public function getByType($type, $user_id)
    {
        return File::where('user_id', $user_id)
            ->where('type', $type)
            ->get();
    }
}
