<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param $message
     * @param $result
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($message,$result=[],$code = 200)
    {
        $response = [
            'success' => true,
            'code' => $code,
            'message' => $message,
            'data'    => $result,
        ];
        return response()->json($response, 200);

    }

    /**
     * return error response.
     *
     * @param $errorMessages
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public function sendError($errorMessages, $code = 201)
    {
        $response = [
            'success' => false,
            'code' => $code,
            'message' => $errorMessages,
        ];
//
//        if(!empty($errorMessages)){
//            $response['data'] = $errorMessages;
//        }else{
//            $response['data'] = array();
//        }
        return response()->json($response, $code);
    }
}
