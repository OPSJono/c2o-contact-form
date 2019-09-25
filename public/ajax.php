<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('../vendor/autoload.php');

        $success = true;
        $input = $_POST;

        // Using PHP 7+ syntax here.
        // If Stuck with a version of PHP before 7.0 I would use the traditional isset() ? :
        // $email = isset($input['email']) ? $input['email'] : '';
        // But I find this much nicer to read.

        $category = $input['category'] ?? '';
        $email = $input['email'] ?? '';
        $firstName = $input['firstName'] ?? '';
        $lastName = $input['lastName'] ?? '';
        $phoneNo = $input['phoneNo'] ?? '';

        $dbConnection = db_connect();

        // Prepare the SQL statement to avoid SQL Injection from the User Input.
        $sql = $dbConnection->prepare('INSERT INTO contact_form (category_id, email,first_name,last_name,phone) VALUES (?, ?, ?, ?, ?);');
        $sql->bind_param('issss', $category, $email, $firstName, $lastName, $phoneNo);
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