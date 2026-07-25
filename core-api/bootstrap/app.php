<?php

use System\Services\ApplicationHandle;
use System\Services\Response\ResponseResolver as Response;

try{
    
    $application = new ApplicationHandle();
    
    $application->handle();

}catch(Throwable $e){

    echo Response::responseJson([
        "message" => $e->getMessage()
    ], $e->getCode()??500);
}


