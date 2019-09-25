<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('../vendor/autoload.php');

        $success = true;
        $input = $_POST;

        // Using PHP 7+ syntax here.
        // If Stuck with a version of PHP before 7.0 I would use the traditional isset() ? :
        // $email = isset($input['email']) ? $input['email'] : '';
        // But I find this much nicer to read.

        // Integer fields
        $category = sanitizeInt($input['category'] ?? '');
        $orderNumber = sanitizeInt($input['orderNumber'] ?? '');

        // String free form fields
        $email = sanitizeString($input['email'] ?? '');
        $firstName = sanitizeString($input['firstName'] ?? '');
        $lastName = sanitizeString($input['lastName'] ?? '');
        $phoneNo = sanitizeString($input['phoneNo'] ?? '');
        $comment = sanitizeString($input['comment'] ?? '');

        $dbConnection = db_connect();

        // Prepare the SQL statement to avoid SQL Injection from the User Input.
        $sql = $dbConnection->prepare('INSERT INTO contact_form (category_id, order_number, email, first_name, last_name, phone, comment) VALUES (?, ?, ?, ?, ?, ?, ?);');
        $sql->bind_param('iisssss', $category, $orderNumber, $email, $firstName, $lastName, $phoneNo, $comment);
        $sql->execute();

        $error = db_error($dbConnection);
        if(!empty($error)) {
            $success = false;
        }

        echo json_encode([
            'success' => $success,
            'error' => $error,
        ]);
    }
?>