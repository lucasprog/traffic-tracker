<?php

namespace System\Services\Request;

use System\Services\Request\RequestResolverInterface;

use Exception;

class RequestResolver implements RequestResolverInterface
{
    private string $requestURI = "";
    private string $requestMethod = "";
    private string $requestQueryString = "";

    public function __construct()
    {
        $this->requestURI = $_SERVER["REQUEST_URI"];
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
        $this->requestQueryString = $_SERVER['QUERY_STRING'];        
    }

    private function cleanRequestURI(): void
    {
        if( strpos($this->requestURI,"?") ) {
            $this->requestURI = str_replace("?" . $this->requestQueryString,"",$this->requestURI);
        }   
    }

    public function data(): array
    {
        $this->cleanRequestURI(); 

        return [
            "route" => $this->requestURI,
            "method" => $this->requestMethod,
            "query_string" => $this->requestQueryString
        ];
    }

    public function currentRoute(): string
    {
        $this->cleanRequestURI(); 
        return $this->requestURI;
    }

    public function queryString(): string
    {
        return $this->requestQueryString;
    }

    public function methodRequest(): string
    {
        return $this->requestMethod;
    }

    public function onlyAPI():void
    {
        $appConfig = config("app");

        if( $appConfig["only_api"] ) {
            if( $_SERVER['HTTP_ACCEPT'] !== "application/json" && $_SERVER['HTTP_CONTENT_TYPE'] !== "application/json" ) {
                throw new Exception("Unauthorized request",401);
            }
        }
    }

}