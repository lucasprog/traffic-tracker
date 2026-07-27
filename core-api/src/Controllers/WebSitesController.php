<?php

namespace App\Controllers;

use App\Services\WebSitesService;
use System\Services\Request\Request;
use System\Services\Response\ResponseResolver as Response;

class WebSitesController
{

    public function __construct(protected WebSitesService $websiteService){}

    public function get(Request $request)
    {
        $params = $request->get();
        
        return Response::responseJson($this->websiteService->get($params));
    }

    public function store(Request $request )
    {
        
        if( $this->websiteService->create($request->post()) ){
            return Response::responseJson([
                "success" => true,
                "message" => "Website created with success!"
            ],201);
        }

        return Response::responseJson([
            "success" => false,
            "message" => "Oops, something happened to create Website!"
        ],500);

    }

    public function update(Request $request, int $id)
    {        
        if( $this->websiteService->update($request->post(), $id) ){
            return Response::responseJson([
                "success" => true,
                "message" => "Website updated with success!"
            ],200);
        }

        return Response::responseJson([
            "success" => false,
            "message" => "Oops, something happened to update Website!"
        ],500);
        
    }

    public function delete(int $id)
    {        
        if( $this->websiteService->delete($id) ){
            return Response::responseJson([
                "success" => true,
                "message" => "Website deleted with success!"
            ],200);
        }

        return Response::responseJson([
            "success" => false,
            "message" => "Oops, something happened to delete Website!"
        ],500);
        
    }
}