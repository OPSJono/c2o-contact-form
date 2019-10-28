<?php

namespace App\Models;

use \App\Helpers;
use \PDO;

class ContactForm extends BaseModel {

    public function insert(int $categoryId, int $personId, string $comment, ?int $orderNumber = null)
    {
        $categoryId = Helpers::sanitizeInt($categoryId);
        $personId = Helpers::validateEmail($personId);
        $orderNumber = Helpers::sanitizeInt($orderNumber);
        $comment = Helpers::sanitizeString($comment);

        $statement = $this->connection->prepare('INSERT INTO `contact_form` (`category_id`, `person_id`, `order_number`, `comment`) 
                                                            VALUES (:category_id, :person_id, :order_number, :comment_value);');

        $statement->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindParam(':person_id', $personId, PDO::PARAM_INT);
        $statement->bindParam(':order_number', $orderNumber, PDO::PARAM_INT);
        $statement->bindParam(':comment_value', $comment, PDO::PARAM_STR);

        $result = $statement->execute();

        if($result !== false) {
            $result = $this->connection->lastInsertId();
        }

        return $result;
    }
}