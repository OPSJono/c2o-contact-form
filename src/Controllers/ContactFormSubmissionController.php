<?php

namespace App\Controllers;

use \RuntimeException;
use \PDO;

use \App\Helpers;

use \App\Models\Category;
use \App\Models\ContactForm;
use \App\Models\Person;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


/**
 * Class ContactFormSubmissionController
 * @package App\Controllers
 */
class ContactFormSubmissionController {

    /**
     * @var bool|PDO
     */
    protected $connection;
    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var bool
     */
    protected $noScript = false;
    /**
     * @var null
     */
    protected $success = null;
    /**
     * @var array
     */
    protected $errors = [];
    /**
     * @var array
     */
    protected $input = [];

    /**
     * ContactFormSubmissionController constructor.
     */
    public function __construct()
    {
        $this->connection = Helpers::db_connect();

        $twigLoader = new FilesystemLoader('../src/Views');
        $this->twig = new Environment($twigLoader, [
            'cache' => '../src/Cache',
            'auto_reload' => true,
        ]);

        if(!$this->connection instanceof PDO) {
            throw new RuntimeException("Unable to connect to the database. Please make sure the Database exists and the connection details are correct.", 500);
        }
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
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

    /**
     * @param array $input
     * @return false|string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function handlePostRequest(array $input = [])
    {
        $this->setInput($input);
        $this->setSuccess(false);

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

        $this->setErrors($errors);

        if(empty($this->getErrors())) {
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
                $this->setSuccess(true);
            }
        }

        if($this->getNoScript() !== false) {
            // If the client doesn't have Javascript enabled, rerender the form.
            if($this->getSuccess() === true) {
                // Clear the input fields if we have saved the form successfully.
                $this->setInput([]);
            }
            return $this->handleGetRequest();
        } else {
            // Otherwise respond to the ajax request.
            return json_encode([
                'success' => $this->getSuccess(),
                'errors' => $this->getErrors(),
            ]);
        }
    }

    /**
     * @return bool
     */
    public function getNoScript()
    {
        return $this->noScript;
    }

    /**
     * @param bool $noScript
     */
    public function setNoScript(bool $noScript)
    {
        $this->noScript = $noScript;
    }

    /**
     * @return null
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param array $input
     */
    public function setInput(array $input)
    {
        $this->input = $input;
    }
}