<?php

namespace App\Services;
use App\Repositories\UserRepository;
use App\Traits\Languages;

class UserService
{
    use Languages;
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function refreshUser($user)
    {
        return $this->userRepository->updateUser($user);
    }

    public function doAuth($login)
    {
        if($user = $this->userRepository->getUserByLogin($login)) {
            \Auth::login($user, true);
            return true;
        }

        return false;
    }

    public function getUserById($id)
    {
        if($user = $this->userRepository->getUserById($id)) {
            return $user;
        }

        return false;
    }

    public function getPeopleCategory($id, $count)
    {

        $users = $this->userRepository->getPeopleByCategory($id, $count);

        $user_obj = $this->getUserObject($users);

        return $user_obj;

    }

    public function getPeopleCategoryPagination($id, $count)
    {
        $users = $this->userRepository->getPeopleByPaginate($id, $count);
        $user_obj = $this->getUserObject($users);
        return ['users' => $users, 'obj' => $user_obj];
    }

    public function getUser($id)
    {
        $user = $this->userRepository->getUserActive($id);

        if (!$user) return abort(404);

        return $this->getUserObject($user);

    }

    public function getAuthenticated()
    {
        if ($user = $this->userRepository->getAuthUser())
            return $user;
        else return false;

    }

    public function getReviews($id)
    {
        return \App\Models\Review::where('user_id', $id)->approved()->get();
    }

    public function getPeople($count=5)
    {
        $users = $this->userRepository->getAll($count);

        $user_obj = $this->getUserObject($users);

        return $user_obj;
    }

    public function getPeoplePagination($count=5)
    {
        $users = $this->userRepository->getAllPagination($count);
        $user_obj = $this->getUserObject($users);
        return ['users' => $users, 'obj' => $user_obj];
    }

    public function checkUser($token)
    {
        $url = 'test.com';

        try {
            $response = $this->userRepository->query($url, [
                'method' => 'getUser',
                'token' => $token
            ]);

            $user = $response->body();

            if (isset($user['login'])) {
                if (!$this->userRepository->getUserByLogin($user['login']))
                    return back()->withErrors('Error');
                else return $user;
            }

        }catch (\RequestException $exception) {
            report($exception);
            return back()->withErrors($exception->getMessage());
        }

        return false;
    }

    private function getUserObject($user)
    {

        return $user->map(function ($u) {
            $group = \App\Models\Group::with('groupStrings')->whereId($u->group_id)->IsShowed()->first();

            $data = ['group' => '', 'city' => '', 'user' => $u, 'userStrings' => ['is_exists' => true, 'data' => '']];

            $data['reviews'] = $u->reviews()->approved()->count();

            $category =  \App\Models\CategoryStrings::where('category_id', $u->category_id)->where('lang_id', $this->getLangId())->first();

            $city =  \App\Models\CityStrings::where('city_id', $u->city_id)->where('lang_id', $this->getLangId())->first();

            $data['category'] = $category;
            $data['city'] = $city;

            if (!$user_strings = $this->userRepository->getUsersStringsById($u->id)) $data['userStrings']['is_exists'] = false;
            else $data['userStrings']['data'] = $user_strings;

            if ($group->groupStrings()->count() > 0) {

                $group_return = false;
                foreach ($group->groupStrings()->get() as $gr) {
                    if ($gr->lang_id === $this->getLangId()) $group_return = $gr;
                }

                if (!$group_return) $group_return = $group->groupStrings()->where('lang_id', $this->getLangMainId())->first();

                $data['group'] = $group_return->name;
            }
            return $data;
        });
    }

}
