<?php


if( !function_exists("config")) 
{
    function config(string $configName){
        $configuration = require_once __DIR__ . "/" . $configName . ".php";
        return $configuration;
    }
}

