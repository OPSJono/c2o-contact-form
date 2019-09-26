<?php

namespace App\Models;

use \App\Helpers;
use \PDO;

class ContactForm extends BaseModel {

    public function insert(int $categoryId, string $email, ?int $orderNumber = null, ?string $firstName = null, ?string $lastName = null, ?string $phone = null, ?string $comment = null)
    {
        $categoryId = Helpers::sanitizeInt($categoryId);
        $email = Helpers::validateEmail($email);
        $orderNumber = Helpers::sanitizeInt($orderNumber);
        $firstName = Helpers::sanitizeString($firstName);
        $lastName = Helpers::sanitizeString($lastName);
        $phone = Helpers::sanitizeString($phone);
        $comment = Helpers::sanitizeString($comment);

        $statement = $this->connection->prepare('INSERT INTO `contact_form` (`category_id`, `email`, `order_number`, `first_name`, `last_name`, `phone`, `comment`) 
                                                            VALUES (:category_id, :email, :order_number, :first_name, :last_name, :phone, :comment_value);');

        $statement->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':order_number', $orderNumber, PDO::PARAM_INT);
        $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
        $statement->bindParam(':comment_value', $comment, PDO::PARAM_STR);

        $result = $statement->execute();

        return $result;
    }
}