<?php

namespace App\Controllers;

use App\Services\PagesService;
use System\Services\Request\Request;
use System\Services\Response\ResponseResolver as Response;

class PagesController
{
      public function __construct(protected PagesService $pagesService){}

    public function getByWebsite(int $website_id, Request $request)
    {
        $params = $request->get();
        
        $this->pagesService->setWebsite($website_id);
        return Response::responseJson($this->pagesService->getDataTrack($params));
    }

    public function getAll(Request $request)
    {
        $params = $request->get();
        return Response::responseJson($this->pagesService->getDataTrack($params));
    }

    public function tracking(Request $request )
    {
        
        if( $this->pagesService->create($request->post()) ){
            return Response::responseJson([
                "success" => true,
                "message" => "Access tracked with success!"
            ],201);
        }

        return Response::responseJson([
            "success" => false,
            "message" => "Oops, something happened to track access page!"
        ],500);

    }

}