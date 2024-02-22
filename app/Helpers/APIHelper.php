<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

class APIHelper
{

    /**
     * @param int $statusCode
     * @param string $message
     * @param array|null $payload
     * @return Response
     */
    public static function responseBuilder(int $statusCode, string $message, string $status, $payload = null) : Response
    {

        return response()->json([
            'status' => $status,
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $payload,
        ], $statusCode);

    }
}
