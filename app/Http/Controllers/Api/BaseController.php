<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    //
     //
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function successResponse($result, $message)
    {
        $response = [
            'code' => 200,
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];
        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function send404Error($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'code' => 404,
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function send500Error($error, $errorMessages = [], $code = 500)
    {
        $response = [
            'code' => 500,
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
    public function send400Error($error, $errorMessages = [], $code = 400)
    {
        $response = [
            'code' => 400,
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function send422Error($error, $errorMessages = [], $code = 422)
    {
        $response = [
            'code' => 422,
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
