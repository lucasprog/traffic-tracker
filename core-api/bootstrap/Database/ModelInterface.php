<?php

namespace System\Database;

use System\Database\Connection;
use stdClass;

interface ModelInterface
{

    public function create(array $datasToInsert): bool;

    public function delete(int $id): bool;

    public function update(array $dataToUpdate, string $whereNameColumn, string $whereValue): bool;

    public function get(?string $columns = null): array;

    public function find(string $whereNameColumn, string $whereValue, ?string $columns = null): stdClass;

}