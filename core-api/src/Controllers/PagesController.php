<?php

namespace App\Controllers;

use App\Services\PagesService;
use System\Services\Request\Request;
use System\Services\Response\ResponseResolver as Response;

class PagesController
{
      public function __construct(protected PagesService $pagesService){}

    public function get(int $website_id, Request $request)
    {
        $params = $request->get();
        
        $this->pagesService->setWebsite($website_id);
        return Response::responseJson($this->pagesService->get($params, $website_id));
    }

    public function store(Request $request )
    {
        
        if( $this->pagesService->create($request->post()) ){
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
        if( $this->pagesService->update($request->post(), $id) ){
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
        if( $this->pagesService->delete($id) ){
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