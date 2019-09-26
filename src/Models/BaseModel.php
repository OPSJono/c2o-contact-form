<?php

namespace App\Models;

use \PDO;

class BaseModel {

    protected $connection;

    public function __construct(PDO $db)
    {
        $this->connection = $db;
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}