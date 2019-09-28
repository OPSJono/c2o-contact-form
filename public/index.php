<?php
use \App\ContactFormSubmission;

require_once('../vendor/autoload.php');

try {
    $form = new ContactFormSubmission();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Handle the POST request
        $input = $_POST;
        $form->handlePostRequest($input);

        $success = $form->getSuccess();
        $errors = $form->getErrors();

        if($form->getNoScript() !== false) {
            // If the client doesn't have Javascript enabled, rerender the form.
            if($success === true) {
                // Clear the input fields if we have saved the form successfully.
                $form->setInput([]);
            }
            echo $form->handleGetRequest();
        } else {
            // Otherwise respond to the ajax request.
            echo json_encode([
                'success' => $success,
                'errors' => $errors,
            ]);
        }
    } else {
        // Handle GET request
        // Render the form.
        echo $form->handleGetRequest();
    }
} catch (\Error $exception) {
    include_once 'views/error.php';
} catch (\Throwable $exception) {
    include_once 'views/error.php';
}