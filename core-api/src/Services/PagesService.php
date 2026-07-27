<?php

namespace App\Services;

use App\Models\PagesModel;
use Exception;
use System\Database\ModelInterface;
use stdClass;


class PagesService
{
    protected ModelInterface $model;
    protected stdClass $website;

    public function __construct(PagesModel $model, 
    protected WebSitesService $websitesService)
    {
        $this->model = $model;
    }

    public function validate(array $data)
    {
        $errorMessage = "";

        if( !isset($data['name'])  )
        {
            $errorMessage .= "The name is required!" . PHP_EOL;
        }

        if( !isset($data['route'])  )
        {
            $errorMessage .= "The route is required!" . PHP_EOL;
        }

        if( !isset($data['visitor_id'])  )
        {
            $errorMessage .= "The visitor_id is required!" . PHP_EOL;
        }

        if( !isset($data['domain'])  )
        {
            $errorMessage .= "The domain is required!" . PHP_EOL;
        }

        if( !empty($errorMessage) ){
            throw new Exception($errorMessage);
        }

    }

    public function setWebsite(int $website_id): void 
    {
        $this->website = $this->websitesService->find($website_id);

        if( !$this->website ){
            throw new Exception("Website not found!", 404);
        }
    }

    public function create(array $data)
    {

        $this->validate($data);
        
        return $this->model->create($data);
    }

    public function update(array $data, int $id)
    {

        $this->validate($data);
        
        return $this->model->update($data,'id',$id);
    }

    public function delete(int $id)
    {        
        return $this->model->delete($id);
    }

    public function get(array $params)
    {        
        $where = "website_id = {$this->website->id}";

        if( isset($params["name"]) )
        {
            $where .= " && name = {$params['name']}";
        }

        if( isset($params["route"]) )
        {
            $where .= " && route = {$params['route']}";
        }

        return $this->model->get();
    }

    public function find(int $id)
    {
        return $this->model->find("id",$id);
    }
}