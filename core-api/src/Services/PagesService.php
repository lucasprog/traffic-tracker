<?php

namespace App\Services;

use App\Models\PagesModel;
use Exception;
use System\Database\ModelInterface;
use stdClass;


class PagesService
{
    protected ModelInterface $model;
    protected stdClass|bool $website;

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

    public function setWebsiteByDomain(string $domain): void 
    {
        $this->website = $this->websitesService->findByDomain($domain);

        if( !$this->website ){
            throw new Exception("Website not found!", 404);
        }
    }

    public function create(array $data)
    {

        $this->validate($data);

        $this->setWebsiteByDomain($data['domain']);

        $dataToInsert = [
            "name" => $data["name"],
            "route" => $data["route"],
            "visitor_id" => $data["visitor_id"],
            "website_id" => $this->website->id
        ];

        return $this->model->create($dataToInsert);
    }
  
    public function getDataTrack(array $params)
    {        
        $model = $this->model
            ->selectDistinct("name,route, COUNT(DISTINCT visitor_id) as unique_visits,website_id");

        if( isset($this->website) )
        {
            $model->where('website_id',$this->website->id);
        }

        if( isset($params["start_at"]) )
        {
            $model->where("created_at",">=",$params["start_at"] . " 00:00:00");
            unset($params["start_at"]);
        }

        if( isset($params["end_at"]) )
        {
            $model->where("created_at","<=",$params["end_at"] . " 23:59:59");
            unset($params["end_at"]);
        }

        foreach($params as $key => $param)
        {
            $model = $model->where($key,$param);
        }

        return $model->groupBy("name,route,website_id")->orderBy("unique_visits","DESC")->get();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function delete(string $column, string $value)
    {        
        return $this->model->delete($column, $value);
    }
}