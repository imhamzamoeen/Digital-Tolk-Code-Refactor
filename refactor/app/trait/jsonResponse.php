<?php

namespace App\trait;

class jsonResponse
{
    public static function success(object $data,string $message="success"):jsonResponse
    {
        return response()->json(['data' => $data, 'message' => $message],201);
    }

    public static function error(object $data=[],string $message="error"):jsonResponse
    {
        return response()->json(['data' => 'Abigail', 'message' => $message],400);

    }

    public static function exception($data,$message="exception"):jsonResponse
    {
        return response()->json(['data' => $data, 'message' => $message],500);

    }
}