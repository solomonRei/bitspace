<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Services\UserService;
use Illuminate\Http\Request;

class CheckUserApiController extends BaseController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkUser(Request $request)
    {
        $data = $request->json()->all();
        if (isset($data['user']['login']) && !empty($data['user']['login']))
            if ($token = $this->userService->storeOrGetUser($data['user']))
                return $this->sendResponse('Success', [
                    'token' => $token
                ]);

        return $this->sendError('Invalid Data');
    }
}
