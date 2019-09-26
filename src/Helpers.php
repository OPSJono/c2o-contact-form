<?php

namespace App;

use \PDO;
use \PDOException;

class Helpers {
    public static function db_connect()
    {
        try {
            return new PDO('mysql:host=127.0.0.1;dbname=cto;charset=utf8mb4', 'root', 'reverse');
        } catch (PDOException $e) {
            // echo 'Connection failed: ' . $e->getMessage();
            return false;
        }

    }

    public static function validateEmail(?string $email = null)
    {
        filter_var(trim($email), FILTER_VALIDATE_EMAIL);
        if(empty($email)) {
            return null;
        }

        return $email;
    }

    public static function sanitizeString(?string $value = null)
    {
        $value = filter_var(trim($value));
        if(empty($value)) {
            return null;
        }

        return $value;
    }

    public static function sanitizeInt($value = null)
    {
        $value = filter_var(trim($value), FILTER_VALIDATE_INT);
        if(empty($value)) {
            return null;
        }

        return $value;
    }
}