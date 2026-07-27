<?php

namespace App\Services;

use App\Models\WebSitesModel;
use Exception;
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

    public function get()
    {        
        return $this->model->get();
    }

    public function find(int $id)
    {        
        return $this->model->find("id",$id);
    }
}