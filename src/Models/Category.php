<?php

namespace App\Models;

use \App\Helpers;
use \PDO;

class Category extends BaseModel {

    public function find(int $id)
    {
        $id = Helpers::sanitizeInt($id);

        $statement = $this->connection->prepare('select id from categories where id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        if ($statement->rowCount() > 0) {
            $result = $statement->fetch();
        } else {
            $result = false;
        }

        return $result;
    }

    public function all()
    {
        $statement = $this->connection->prepare('select id, name from categories;');
        $statement->execute();

        if ($statement->rowCount() > 0) {
            $result = $statement->fetchAll();
        } else {
            $result = [];
        }

        return $result;
    }
}