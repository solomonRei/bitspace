<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UsersStrings;
use App\Traits\Languages;
use Illuminate\Support\Facades\Auth;

class UserRepository extends CoreRepository
{
    use Languages;

    public function getUserByLogin($login)
    {
        return User::where('login', $login)->first();
    }

    public function getUserById($id)
    {
        return User::whereId($id)->first();
    }

    public function getUserActive($id)
    {
        return User::isShown()->teachers()->whereId($id)->get();
    }

    public function getAuthUser()
    {
        return User::find(Auth::id());
    }

    public function getUserObject($id)
    {
        return User::find($id);
    }


    public function getPeopleByCategory($id, $count = 5)
    {
        return User::where('category_id', $id)
            ->isShown()
            ->isSearched()
            ->teachers()
            ->limit($count)
            ->orderBy('created_at')
            ->get();
    }

    public function getPeopleByPaginate($id, $count = 5)
    {
        return User::where('category_id', $id)
            ->isShown()
            ->isSearched()
            ->teachers()
            ->orderBy('created_at')
            ->paginate($count);
    }


    public function getAll($count = 5)
    {
        return User::limit($count)
            ->isShown()
            ->isSearched()
            ->teachers()
            ->orderBy('created_at')
            ->get();
    }
    public function getAllPagination($count = 5)
    {
        return User::isShown()
            ->isSearched()
            ->teachers()
            ->orderBy('created_at')
            ->paginate($count);
    }

    public function getUsersStringsById($id)
    {
        return UsersStrings::where('user_id', $id)
            ->where('lang_id', $this->getLangId())
            ->first();
    }

}
