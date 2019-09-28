<?php

namespace App;

use \RuntimeException;
use \PDO;

use App\Models\Category;
use App\Models\ContactForm;
use App\Models\Person;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ContactFormSubmission {

    protected $connection;
    protected $twig;

    protected $noScript = false;
    protected $success = null;
    protected $errors = [];
    protected $input = [];

    public function __construct()
    {
        $this->connection = Helpers::db_connect();

        $twigLoader = new FilesystemLoader(getcwd().DIRECTORY_SEPARATOR.'views');
        $this->twig = new Environment($twigLoader, [
            'cache' => getcwd().DIRECTORY_SEPARATOR.'cache',
            'auto_reload' => true,
        ]);

        if(!$this->connection instanceof PDO) {
            throw new RuntimeException("Unable to connect to the database. Please make sure the Database exists and the connection details are correct.", 500);
        }
    }

    public function handleGetRequest()
    {
        $category = new Category($this->connection);
        $categories = $category->all();

        // Render the form.
        return $this->twig->render('form.html.twig', [
            'categories' => $categories,
            'success' => $this->getSuccess(),
            'errors' => $this->getErrors(),
            'input' => $this->getInput(),
        ]);
    }

    public function handlePostRequest(array $input = [])
    {
        $success = false;
        $errors = [];

        // Trim and filter the values from the input.
        $categoryId = Helpers::arrayGet($input, 'categoryId');
        $categoryId = Helpers::sanitizeInt($categoryId);

        $email = Helpers::arrayGet($input, 'email');
        $email = Helpers::validateEmail($email);

        $orderNumber = Helpers::arrayGet($input, 'orderNumber');
        $orderNumber = Helpers::sanitizeInt($orderNumber);

        $firstName = Helpers::arrayGet($input, 'firstName');
        $firstName = Helpers::sanitizeString($firstName);

        $lastName = Helpers::arrayGet($input, 'lastName');
        $lastName = Helpers::sanitizeString($lastName);

        $phoneNo = Helpers::arrayGet($input, 'phoneNo');
        $phoneNo = Helpers::sanitizeString($phoneNo);

        $comment = Helpers::arrayGet($input, 'comment');
        $comment = Helpers::sanitizeString($comment);


        $noScript = Helpers::arrayGet($input, 'noScript');
        $noScript = Helpers::sanitizeBool((bool) $noScript);
        $this->setNoScript($noScript);

        // Set any user input validation errors
        if(is_null($categoryId)) {
            $errors['categoryId'] = "Please select a Category";
        } else {
            // Find the selected Category and make sure it exists.
            $category = new Category($this->connection);
            $category = $category->find($categoryId);

            if ($category === false) {
                $errors['categoryId'] = "Please select a Category";
            }
        }

        if(is_null($email)) {
            $errors['email'] = "Please provide a valid email address";
        }

        if(is_null($firstName)) {
            $errors['firstName'] = "Please provide your first name";
        }

        if(is_null($lastName)) {
            $errors['lastName'] = "Please provide your last name";
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

        $this->setInput($input);
        $this->setSuccess($success);
        $this->setErrors($errors);
    }

    public function getNoScript()
    {
        return $this->noScript;
    }

    public function setNoScript(bool $noScript)
    {
        $this->noScript = $noScript;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function setInput(array $input)
    {
        $this->input = $input;
    }
}