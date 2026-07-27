<?php

namespace System\Database;

use PDO;

class Connection
{

    private static ?self $instance = null;

    public static function getInstance(): self
    {
        if( self::$instance === null )
        {
          self::$instance = new self();
        }

        return self::$instance;
    }

    public function db(): PDO
    {
        $db_name = $_ENV["DATABASE_NAME"];
        $db_user = $_ENV["DATABASE_USER"];
        $db_host = $_ENV["DATABASE_HOST"];
        $db_password = $_ENV["DATABASE_PASSWORD"];

        return new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4",$db_user, $db_password,[
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
    }

}