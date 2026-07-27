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
    protected array $query = [
        "select" => null,
        "where" => " WHERE ",
        "limit" => null,
        "groupBy" => null,
        "orderBy" => null
    ];
    protected array $queryWhereValues = [];
    private $allowedOperator  = [
        '=', '<', '>', '<=', '>=', '<>', '!=', 
        'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 
        'BETWEEN', 'IS', 'IS NOT'
    ];


    public function __construct()
    {
        $this->db = Connection::getInstance()->db();           
    }

    public function create(array $datasToInsert = []): int
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

        return $this->db->lastInsertId();

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


    public function getAll(?string $columns = null): array
    {   
        $columns = $this->convertColumnsToString();

        $q = "SELECT {$columns} FROM {$this->table};";

        $query = $this->db->query($q);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function select(string $select): ModelInterface
    {   
        $this->query["select"] = "SELECT {$select} FROM {$this->table}";
        return $this;
    }

    public function selectDistinct(string $select): ModelInterface
    {   
        $this->query["select"] = "SELECT DISTINCT {$select} FROM {$this->table}";
        return $this;
    }

    
    public function where(string $column,string $valueOrOperator, ?string $value = null ): ModelInterface
    {

        $this->query["where"] .= $this->query["where"] === " WHERE "? "{$column}" : " AND {$column}";

        $this->whereLogic($valueOrOperator, $value);

        return $this;
        
    }

    public function whereOr(string $column,string $valueOrOperator, ?string $value = null ): ModelInterface
    {

        $this->query["where"] .= $this->query["where"] === " WHERE "? "{$column}" : " OR {$column}";

        $this->whereLogic($valueOrOperator, $value);

        return $this;
        
    }

    public function limit(int $limit): ModelInterface
    {
        $this->query["limit"] = " LIMIT {$limit}";
        return $this;
    }

    public function get(): array
    {
        $query = $this->prepareSelectQuery();
        $query->execute($this->queryWhereValues);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function first(): stdClass|bool
    {
        $this->limit(1);
        $query = $this->prepareSelectQuery();
        $query->execute($this->queryWhereValues);

        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function find(int $id ): stdClass|bool
    {           
        return $this->select("*")->where("id",$id)->first();
    }

    public function delete(string $column, string $value): bool
    {
        $query = $this->db->prepare("DELETE FROM {$this->table} WHERE {$column} = :{$column}");
        $query->bindParam(":{$column}", $value);
        $query->execute();

        return $query->rowCount() > 0;
    }
    
    public function groupBy(string $groupBy): ModelInterface
    {
        $this->query["groupBy"] = " GROUP BY $groupBy";
        return $this;
    }

    public function orderBy(string $orderBy, string $order): ModelInterface
    {
        $this->query["orderBy"] = " ORDER BY {$orderBy} {$order}";
        return $this;
    }

    public function getDB()
    {
        return $this->db;
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

    private function whereLogic(string $valueOrOperator, ?string $value = null)
    {
        if( in_array(strtoupper(trim($valueOrOperator)), $this->allowedOperator, true) )
        {
            $this->query["where"] .= " {$valueOrOperator} ?";
            $this->queryWhereValues[] = $value;
        }else{
            $this->query["where"] .= " = ?";
            $this->queryWhereValues[] = $valueOrOperator;
        }        
    }

    private function prepareSelectQuery()
    {
        $query =  $this->query["select"] . 
            (
                $this->query["where"] === " WHERE "?'':$this->query["where"]
            ) . 
            (
                $this->query['limit']??''
            ) .
            (
                $this->query["groupBy"]??''
            ) .
            (
                $this->query["orderBy"]??''
            );
        return $this->db->prepare($query);
    }



}