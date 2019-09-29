<?php
use \App\Controllers\ContactFormSubmissionController;

require_once('../vendor/autoload.php');

try {
    // Instantiate the controller to handle the request.
    $form = new ContactFormSubmissionController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle the POST request
        $input = $_POST;
        echo $form->handlePostRequest($input);
    } else {
        // Handle GET request
        echo $form->handleGetRequest();
    }
} catch (\Error $exception) {
    include_once 'error.php';
} catch (\Throwable $exception) {
    include_once 'error.php';
}