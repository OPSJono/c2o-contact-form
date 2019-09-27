<?php
use \App\ContactFormSubmission;

require_once('../vendor/autoload.php');

$form = new ContactFormSubmission();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the POST request
    $form->handlePostRequest();

    $success = $form->getSuccess();
    $errors = $form->getErrors();

    echo json_encode([
        'success' => $success,
        'errors' => $errors,
    ]);
} else {
    // Handle GET request
    // Render the form.
    echo $form->handleGetRequest();
}
