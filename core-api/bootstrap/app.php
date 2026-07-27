<?php

use System\Services\ApplicationHandle;
use System\Services\Response\ResponseResolver as Response;

try{
    
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__,2));
    $dotenv->load();

    $application = new ApplicationHandle();
    
    $application->handle();

}catch(Throwable $e){

    echo Response::responseJson([
        "message" => $e->getMessage()
    ]);
}


