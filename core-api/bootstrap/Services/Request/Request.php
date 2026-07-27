<?php

namespace System\Services\Request;

use Exception;

class Request
{
    protected array $data = [];

    public function __construct(protected RequestResolver $requestResolver)
    {
        
    }

    public function post():array
    {
        $rawInput = file_get_contents("php://input");
        $this->data = json_decode($rawInput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Oops, invalid JSON payload",400);
        }

        return $this->data;
        
    }

    public function get():array
    {
        parse_str($this->requestResolver->queryString(), $queryStringToArray);
        return $queryStringToArray;
    }

}