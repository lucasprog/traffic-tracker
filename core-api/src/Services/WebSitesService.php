<?php

namespace App\Services;

use App\Models\WebSitesModel;
use Exception;
use stdClass;
use System\Database\ModelInterface;

class WebSitesService
{
    protected ModelInterface $model;

    public function __construct(WebSitesModel $model)
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

        if( !isset($data['domain'])  )
        {
            $errorMessage .= "The domain is required!" . PHP_EOL;
        }

        if( !empty($errorMessage) ){
            throw new Exception($errorMessage);
        }

    }

    public function create(array $data)
    {

        $this->validate($data);

        if( !$this->findByDomain($data['domain']) )
        {
            $websiteCreated = $this->model->create($data);
    
            if( $websiteCreated )
            {
                return $this->model->select("id,name,domain")->where("id",$websiteCreated)->first();
            }
    
            return $websiteCreated;
            
        }

        throw new Exception("Website exist!");
        
    }

    public function update(array $data, int $id)
    {

        $this->validate($data);
        
        return $this->model->update($data,'id',$id);
    }

    public function delete(int $id)
    {        
        return $this->model->delete("id", $id);
    }

    public function get(array $params)
    {   
        $model = $this->model->select("*");
        
        foreach($params as $key => $param )
        {
            $model->where($key,"like","%".$param."%");   
        }

        return $model->get();
    }

    public function find(int $id):stdClass|bool
    {        
        return $this->model->find($id);
    }

    public function findByDomain(string $domain):stdClass|bool
    {        
        return $this->model->select("*")->where("domain",$domain)->first();
    }
}