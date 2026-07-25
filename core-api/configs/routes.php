<?php

use App\Controllers\API\v1\TestController;

return array(
    [
        "method" => "GET",
        "route" => "/",
        "controller" => TestController::class . "@index"
    ],
    [
        "method" => "GET",
        "route" => "/about",
        "controller" => TestController::class . "@about"
    ],
    [
        "method" => "GET",
        "route" => "/blog/{slug}",
        "controller" => TestController::class . "@blog"
    ],
    [
        "method" => "GET",
        "route" => "/site/{id}/edit",
        "controller" => TestController::class . "@blog"
    ],
    [
        "method" => "GET",
        "route" => "/site/{id}/edit/{slug}",
        "controller" => TestController::class . "@blog"
    ]
);