<?php

namespace App\Libraries;

class Response
{
    /*
        200: OK
        201: Created
        400: Bad Request
        401: Unauthorized
        403: Forbidden
        404: Not Found
        500: Internal Server Error 
    */

    public static function json($data = [], $statusCode = 200, $messages = [])
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        if ($messages  !== []) {
            echo json_encode([
                'status' => $statusCode,
                'messages' => $messages,
            ]);
            exit;
        }

        echo json_encode([
            'status' => $statusCode,
            'data' => $data,
        ]);
        exit;
    }
}
