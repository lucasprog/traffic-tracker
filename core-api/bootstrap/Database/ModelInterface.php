<?php

namespace System\Database;

use System\Database\Connection;
use stdClass;

interface ModelInterface
{

    public function create(array $datasToInsert): int;

    public function delete(string $column, string $value): bool;

    public function update(array $dataToUpdate, string $whereNameColumn, string $whereValue): bool;

    public function getAll(?string $columns = null): array;

    public function find(int $id ): stdClass|bool;

    public function select(string $select): ModelInterface;

    public function selectDistinct(string $select): ModelInterface;

    public function where(string $column,string $valueOrOperator, ?string $value = null ): ModelInterface;

    public function whereOr(string $column,string $valueOrOperator, ?string $value = null ): ModelInterface;

    public function limit(int $limit): ModelInterface;

    public function first(): stdClass|bool;

    public function get(): array;

    public function groupBy(string $groupBy): ModelInterface;
    
    public function orderBy(string $orderBy, string $order): ModelInterface;

}