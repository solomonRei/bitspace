<?php

namespace App\Repositories;

use App\Contracts\PlatformContract;
use App\Models\Conference;
use App\Services\UserService;
use Firebase\JWT\JWT;

class ZoomRepository implements PlatformContract
{
    protected $userService;
    private $zoom_api_key = 'DqYkwUPfRTqZdOJTtKS91g';
    private $zoom_api_secret = '5fsnRxf90c1wSD5WsuDkf9j98a7lftijQ21L';

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(array $data, int $id)
    {
        $post_time = $data['start_date'];
        $start_time = gmdate("Y-m-d\Th:i:s", strtotime($post_time));

        $createMeetingArray = array();
        if (!empty($data['alternative_host_ids'])) {
            if (count($data['alternative_host_ids']) > 1) {
                $alternative_host_ids = implode(",", $data['alternative_host_ids']);
            } else {
                $alternative_host_ids = $data['alternative_host_ids'][0];
            }
        }


        $createMeetingArray['topic'] = $data['topic'];
        $createMeetingArray['agenda'] = !empty($data['agenda']) ? $data['agenda'] : "";
        $createMeetingArray['type'] = !empty($data['type']) ? $data['type'] : 2; //Scheduled
        $createMeetingArray['start_time'] = $start_time;
        $createMeetingArray['timezone'] = 'Asia/Tashkent';
        $createMeetingArray['password'] = !empty($data['password']) ? $data['password'] : "";
        $createMeetingArray['duration'] = !empty($data['duration']) ? $data['duration'] : 60;

        $createMeetingArray['settings'] = array(
            'join_before_host' => !empty($data['join_before_host']) ? true : false,
            'host_video' => !empty($data['option_host_video']) ? true : false,
            'participant_video' => !empty($data['option_participants_video']) ? true : false,
            'mute_upon_entry' => !empty($data['option_mute_participants']) ? true : false,
            'enforce_login' => !empty($data['option_enforce_login']) ? true : false,
            'auto_recording' => !empty($data['option_auto_recording']) ? $data['option_auto_recording'] : "none",
            'alternative_hosts' => isset($alternative_host_ids) ? $alternative_host_ids : ""
        );

        $data = $this->sendRequest($createMeetingArray, $id);

        if (isset($data->code)) {
           return false;
        } else {
            $user = $this->userService->getAuthenticated();
            if ($conference = Conference::create([
                'user_id_owner' => $id,
                'user_id' => $user->id,
                'date_of_lesson' => date_format(date_create($data->start_time), 'Y-m-d H:i:s'),
                'type' => 'zoom',
                'join_url' => $data->join_url,
                'link' => $data->start_url,
                'password' => $data->password
            ])) return $conference;
        }

        return false;
    }

    protected function sendRequest($data, $owner_id)
    {
        if ($user = $this->userService->getUserById($owner_id)) {

            $request_url = "https://api.zoom.us/v2/users/" . $user->email . "/meetings";

            $headers = array(
                "authorization: Bearer " . $this->generateJWTKey(),
                "content-type: application/json",
                "Accept: application/json",
            );

            $postFields = json_encode($data);

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $request_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postFields,
                CURLOPT_HTTPHEADER => $headers,
            ));

            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
            if (!$response) {
                return $err;
            }
            return json_decode($response);
        }
        return false;
    }

    private function generateJWTKey()
    {
        $key = $this->zoom_api_key;
        $secret = $this->zoom_api_secret;
        $token = array(
            "iss" => $key,
            "exp" => time() + 3600 //60 seconds as suggested
        );
        return JWT::encode($token, $secret);
    }
}
