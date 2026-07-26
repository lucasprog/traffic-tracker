<?php

namespace App\Controllers\API\v1;

use System\Services\Response\ResponseResolver as Response;
use System\Database\Connection;

class TestController
{

    public function index()
    {
        echo 'index';
    }

    public function about()
    {
        echo 'about';
    }

    public function blog(string $id, string $slug)
    {
        
        return Response::responseJson([
            "message" => "yes, everything ok!"
        ]);
    }

}