<?php

namespace App\Services;

use App\Models\User;
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

    /**
     * @param $user
     * @return bool
     */
    public function refreshUser($user)
    {
        return $this->userRepository->updateUser($user);
    }

    /**
     * @param $login
     * @return bool
     */
    public function doAuth($login)
    {
        if ($user = $this->userRepository->getUserByLogin($login)) {
            \Auth::login($user, true);
            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function getUserById($id)
    {
        if ($user = $this->userRepository->getUserById($id)) {
            return $user;
        }

        return false;
    }

    /**
     * @param $id
     * @param $count
     * @return mixed
     */
    public function getPeopleCategory($id, $count)
    {

        $users = $this->userRepository->getPeopleByCategory($id, $count);

        $user_obj = $this->getUserObject($users);

        return $user_obj;

    }

    /**
     * @param $user
     * @return mixed
     */
    private function getUserObject($user)
    {

        return $user->map(function ($u) {
            $group = \App\Models\Group::with('groupStrings')->whereId($u->group_id)->IsShowed()->first();

            $data = ['group' => '', 'city' => '', 'user' => $u, 'userStrings' => ['is_exists' => true, 'data' => '']];

            $data['reviews'] = $u->reviews()->approved()->count();

            $category = \App\Models\CategoryStrings::where('category_id', $u->category_id)->where('lang_id', $this->getLangId())->first();

            $city = \App\Models\CityStrings::where('city_id', $u->city_id)->where('lang_id', $this->getLangId())->first();

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

    /**
     * @param $id
     * @param $count
     * @return array
     */
    public function getPeopleCategoryPagination($id, $count)
    {
        $users = $this->userRepository->getPeopleByPaginate($id, $count);
        $user_obj = $this->getUserObject($users);
        return ['users' => $users, 'obj' => $user_obj];
    }

    /**
     * @param $id
     * @return mixed|void
     */
    public function getUser($id)
    {
        $user = $this->userRepository->getUserActive($id);

        if (!$user) return abort(404);

        return $this->getUserObject($user);

    }

    /**
     * @return bool
     */
    public function getAuthenticated()
    {
        if ($user = $this->userRepository->getAuthUser())
            return $user;
        else return false;

    }

    /**
     * @param $id
     * @return mixed
     */
    public function getReviews($id)
    {
        return \App\Models\Review::where('user_id', $id)->approved()->get();
    }

    /**
     * @param int $count
     * @return mixed
     */
    public function getPeople($count = 5)
    {
        $users = $this->userRepository->getAll($count);

        $user_obj = $this->getUserObject($users);

        return $user_obj;
    }

    /**
     * @param int $count
     * @return array
     */
    public function getPeoplePagination(int $count = 5)
    {
        $users = $this->userRepository->getAllPagination($count);
        $user_obj = $this->getUserObject($users);
        return ['users' => $users, 'obj' => $user_obj];
    }

    /**
     * @param $user
     * @return string
     */
    public function storeOrGetUser($user): string
    {
        if (!$userCurrent = $this->userRepository->getUserByLogin($user['login'])) {
            $newUser = User::create([
                'login' => $user['login'],
                'email' => $user['email'],
                'password' => '',
                'api_token' => ''
            ]);

            $token = $newUser->api_token;
        } else {
            $token = $userCurrent->api_token;
        }

        return $token;
    }

    public function getUserToken(string $token)
    {
        if ($user = $this->userRepository->getUserByToken($token)) {
            return $user;
        }

        return false;
    }

    public function checkUser(string $token): bool
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

        } catch (\RequestException $exception) {
            report($exception);
            return back()->withErrors($exception->getMessage());
        }

        return false;
    }

}
