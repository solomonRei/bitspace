<?php


namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

abstract class CoreRepository
{
    public function query($url, $data)
    {
        $response = Http::withToken('TOKEN')
            ->post($url, $data);

        if (!$response->successful()) $response->throw();

        return $response;
    }

    public function updateUser($user)
    {
        User::whereId($user['token'])->update([
            // Data Fields
        ]);
        return true;
    }
}
