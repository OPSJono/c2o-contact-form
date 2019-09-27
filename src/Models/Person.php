<?php

namespace App\Models;

use \App\Helpers;
use \PDO;

class Person extends BaseModel {

    public function insert(string $email, string $firstName, string $lastName, ?string $phone = null)
    {
        $email = Helpers::validateEmail($email);
        $firstName = Helpers::sanitizeString($firstName);
        $lastName = Helpers::sanitizeString($lastName);
        $phone = Helpers::sanitizeString($phone);

        $statement = $this->connection->prepare('INSERT INTO `persons` (`email`,`first_name`, `last_name`, `phone`) 
                                                            VALUES (:email, :first_name, :last_name, :phone);');

        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);

        $result = $statement->execute();

        if($result !== false) {
            $result = $this->connection->lastInsertId();
        }

        return $result;
    }

    public function update(int $id, string $email, string $firstName, string $lastName, ?string $phone = null)
    {
        $id = Helpers::sanitizeInt($id);
        $email = Helpers::validateEmail($email);
        $firstName = Helpers::sanitizeString($firstName);
        $lastName = Helpers::sanitizeString($lastName);
        $phone = Helpers::sanitizeString($phone);

        $statement = $this->connection->prepare('UPDATE `persons` SET `email` = :email, `first_name` = :first_name, `last_name` = :last_name, `phone` = :phone WHERE `id` = :id;');

        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);

        $result = $statement->execute();

        return $result;
    }

    public function findId(string $email, string $firstName, string $lastName)
    {
        $email = Helpers::validateEmail($email);
        $firstName = Helpers::sanitizeString($firstName);
        $lastName = Helpers::sanitizeString($lastName);

        $sql = 'select id from persons where email = :email and first_name = :first_name and last_name = :last_name';
        $statement = $this->connection->prepare($sql);

        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);

        $statement->execute();

        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_ASSOC)['id'];
        }

        return false;
    }
}