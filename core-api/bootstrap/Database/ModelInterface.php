<?php

namespace System\Database;

use System\Database\Connection;

interface ModelInterface
{

    public function create(): void;

    public function get(): void;

}