<?php

namespace System\Database;

use PDO;
use stdClass;
use System\Database\ModelInterface;
use System\Database\Connection;

class Model implements ModelInterface
{

    protected ?PDO $db = null;
    protected ?string $table;
    protected ?array $columns= [];

    public function __construct()
    {
        $this->db = Connection::getInstance()->db();           
    }

    public function create(array $datasToInsert = []): bool
    {

        if( count($datasToInsert) < 1 )
        {
            return false;   
        }

        $datasProcessed = $this->prepareDataQuery($datasToInsert);

        $query = $this->db->prepare("INSERT INTO {$this->table} 
                                        ({$datasProcessed['columns']}) 
                                    VALUES ({$datasProcessed['valuesOfColumn']})
                                ");
        $query ->execute($datasProcessed["valuesCombined"]);

        return $query->rowCount() > 0;

    }

    public function update(array $dataToUpdate, string $whereNameColumn, string $whereValue): bool
    {

        if( count($dataToUpdate) < 1 )
        {
            return false;   
        }

        $datasProcessed = $this->prepareDataQuery($dataToUpdate);

        $query = $this->db->prepare("UPDATE {$this->table} 
                                        SET {$datasProcessed['columnsCombined']} 
                                    WHERE {$whereNameColumn} = {$whereValue}");
        $query ->execute($datasProcessed["valuesCombined"]);

        return $query->rowCount() > 0;

    }


    public function get(?string $columns = null): array
    {   
        $columns = $this->convertColumnsToString();

        $q = "SELECT {$columns} FROM {$this->table};";

        $query = $this->db->query($q);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function find(string $whereNameColumn, string $whereValue, ?string $columns = null ): stdClass
    {   
        $columns = $this->convertColumnsToString();
        
        $query = $this->db->query("SELECT {$columns} 
                                    FROM {$this->table} 
                                    WHERE {$whereNameColumn} = {$whereValue}                               
                                    LIMIT 1;
                                ");

        return $query->fetch(PDO::FETCH_OBJ);

    }

    public function delete(int $id): bool
    {
        if( !isset($id) )
        {
            return false;      
        }   

        $query = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id ");
        $query->bindParam(":id", $id);
        $query->execute();

        return $query->rowCount() > 0;
    }

    private function prepareDataQuery(array $datas)
    {

        $columns    = array_keys($datas);
        $valuesVar = array_map(fn($value) => ":".$value, $columns);
        $valuesCombined = array_combine($valuesVar, $datas);
        $columnsCombined = array_map(fn($value) => $value . " = :" . $value, $columns);
        
        $columnsCombined = implode(", ", $columnsCombined);
        $columns = implode(", ", $columns);
        $valuesVar = implode(", ", $valuesVar);

        return [
            "columns" => "{$columns}",
            "valuesOfColumn" => "{$valuesVar}",
            "columnsCombined" => $columnsCombined,
            "valuesCombined" => $valuesCombined
        ];

    }

    private function convertColumnsToString(?string $columns = null)
    {
        if( is_null($columns) )
        {
            return implode(", ",$this->columns);
        }

        return $columns;
    }

    public function getDB()
    {
        return $this->db;
    }
}