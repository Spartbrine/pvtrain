<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function successResponseWithData($data, $message = "", $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function errorResponseWithMessage($message = '', $code = 500, $errorMesage = '')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $errorMesage
        ], $code);
    }

    public function successResponseSimple($code = 200, $message = '')
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ], $code);
    }
}
