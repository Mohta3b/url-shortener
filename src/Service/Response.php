<?php

namespace Service;


class Response
{
    static function json($content, $statusCode = 200)
    {
        http_response_code($statusCode);
        // send json
        header('Content-Type: application/json');
        echo json_encode($content);

        exit();
    }
}