<?php

use System\Services\ApplicationHandle;
use System\Services\Response\ResponseResolver as Response;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

try{

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__,2));
    $dotenv->load();

    $application = new ApplicationHandle();
    
    $application->handle();

}catch(Throwable $e){

    echo Response::responseJson([
        "message" => $e->getMessage()
    ],500);

}catch(PDOException $e){
    echo Response::responseJson([
        "message" => $e->getMessage()
    ],500);
}


