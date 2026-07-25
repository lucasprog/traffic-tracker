<?php

namespace System\Services\Response;

use Exception;

class ResponseResolver 
{   

    private static function validateStatusCode(int $code)
    {   
        return $code >= 100 && $code <= 599;
    }

    public static function responseJson(array $data, int $code = 200)
    {
        if( !self::validateStatusCode($code) ) {
            http_response_code(500);
            throw new Exception('Invalid status code');
        }

        http_response_code($code);

        return json_encode($data);
    }

}