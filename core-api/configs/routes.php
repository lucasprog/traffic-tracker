<?php

use App\Controllers\WebSitesController;
use App\Controllers\PagesController;

return array(
    [
        "method" => "GET",
        "route" => "/website",
        "controller" => WebSitesController::class . "@get"
    ],
    [
        "method" => "POST",
        "route" => "/website",
        "controller" => WebSitesController::class . "@store"
    ],
    [
        "method" => "PUT",
        "route" => "/website/{id}",
        "controller" => WebSitesController::class . "@update"
    ],
    [
        "method" => "DELETE",
        "route" => "/website/{id}",
        "controller" => WebSitesController::class . "@delete"
    ],
    [
        "method" => "GET",
        "route" => "/pages/all",
        "controller" => PagesController::class . "@getAll"
    ],
    [
        "method" => "GET",
        "route" => "/pages/{website_id}",
        "controller" => PagesController::class . "@getByWebsite"
    ],
    [
        "method" => "POST",
        "route" => "/page/tracking",
        "controller" => PagesController::class . "@tracking"
    ]
);