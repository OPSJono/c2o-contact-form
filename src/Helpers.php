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

    public static function validateEmail(string $email)
    {
        $email = trim($email);
        if(empty($email)) {
            return false;
        }

        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function sanitizeString(string $value)
    {
        $value = trim($value);
        if(empty($value)) {
            return null;
        }

        return filter_var($value);
    }

    public static function sanitizeInt($value)
    {
        $value = trim($value);
        if(empty($value)) {
            return null;
        }

        return filter_var($value, FILTER_VALIDATE_INT);
    }
}