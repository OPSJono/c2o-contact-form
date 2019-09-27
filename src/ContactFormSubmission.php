<?php

namespace App;

use App\Models\Category;
use App\Models\ContactForm;
use App\Models\Person;
use \PDO;

class ContactFormSubmission {

    protected $connection;
    protected $success = false;
    protected $errors = [];

    public function __construct(PDO $db)
    {
        $this->connection = $db;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }

    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function handlePostRequest()
    {
        $success = false;
        $errors = [];

        $input = $_POST;

        // Using PHP 7+ syntax here.
        // If Stuck with a version of PHP before 7.0 I would use the traditional isset() ? :
        // $email = isset($input['email']) ? $input['email'] : '';
        // But I find this much nicer to read.

        // Trim and filter the values from the input.
        $categoryId = Helpers::sanitizeInt($input['categoryId'] ?? '');
        $email = Helpers::validateEmail($input['email'] ?? '');
        $orderNumber = Helpers::sanitizeInt($input['orderNumber'] ?? '');
        $firstName = Helpers::sanitizeString($input['firstName'] ?? '');
        $lastName = Helpers::sanitizeString($input['lastName'] ?? '');
        $phoneNo = Helpers::sanitizeString($input['phoneNo'] ?? '');
        $comment = Helpers::sanitizeString($input['comment'] ?? '');

        // Find the selected Category and make sure it exists.
        $category = new Category($this->connection);
        $category = $category->find($categoryId);

        // Set any user input validation errors
        if ($category === false) {
            $errors['categoryId'] = "Please select a Category";
        }

        if(is_null($email)) {
            $errors['email'] = "Please provide a valid email address";
        }

        if(is_null($firstName)) {
            $errors['firstName'] = "Please provide your given name";
        }

        if(is_null($lastName)) {
            $errors['lastName'] = "Please provide your family name";
        }

        if(is_null($comment)) {
            $errors['comment'] = "Please fill in the comment field";
        }

        if(empty($errors)) {
            // Find or create the Person record:
            $person = new Person($this->connection);
            $personId = $person->findId($email, $firstName, $lastName);

            // If we don't have a person already in the database, create one.
            if($personId === false) {
                $personId = $person->insert($email, $firstName, $lastName, $phoneNo);
            } else {
                // If the person already exists, make sure their details are up to date.
                $person->update($personId, $email, $firstName, $lastName, $phoneNo);
            }

            // Insert the new record.
            $form = new ContactForm($this->connection);
            $contactFormId = $form->insert($categoryId, $personId, $comment, $orderNumber);

            if($contactFormId !== false && $personId !== false) {
                $success = true;
            }
        }

        $this->setSuccess($success);
        $this->setErrors($errors);
    }
}