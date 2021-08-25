<?php

namespace App\Services;
use App\Repositories\UserRepository;

class SettingsService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function updateSettings($data)
    {
        $user = $this->userRepository->getAuthUser();

        if ($user->update($data)) return true;
        else return false;

//        $this->userRepository->query($url, $data)

    }

    public function createOrUpdateSettings($data, $lang_id)
    {
        $user = $this->userRepository->getAuthUser();

        $data['lang_id'] = $lang_id;

        if ($user->userStrings()->updateOrCreate(['lang_id' => $lang_id], $data)) return true;
        else return false;
    }

    public function getUser()
    {
       if(!$user = $this->userRepository->getAuthUser()) return abort(404);
       else return $user;
    }

    public function getUserStrings($user)
    {
        return $this->userRepository->getUsersStringsById($user->id);
    }

    public function formMediaFiles($data_url)
    {
        return [
            "mediafiles_url" => [
                "presentation" => [
                    "url" => $data_url['url'],
                    "file_id" => $data_url['file_id']
                ]
            ]
        ];

    }

    public function include2FAQuery()
    {
        $data = [];
        $url = '';

        if($response = $this->userRepository->query($url, $data)) {
            $user = $response->body();
            $this->userRepository->updateUser($user);

            $user_current = $this->userRepository->getAuthUser();
            $user_current->fa2 = 1;
            $user_current->safe();
        }
        // it'll be created in the further
    }

    public function deleteProfileTemporary()
    {
        if($user = $this->userRepository->getAuthUser()) {
            return $user->delete();
        }
        return false;
    }

}
