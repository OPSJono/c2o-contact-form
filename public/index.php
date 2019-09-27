<?php
use \App\Helpers;
use \App\ContactFormSubmission;
use \App\Models\Category;

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

require_once('../vendor/autoload.php');

$db = Helpers::db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the POST request
    $submission = new ContactFormSubmission($db);
    $submission->handlePostRequest();

    $success = $submission->getSuccess();
    $errors = $submission->getErrors();

    echo json_encode([
        'success' => $success,
        'errors' => $errors,
    ]);
} else {
    // Handle GET request

    // Get the list of all categories
    $category = new Category($db);
    $categories = $category->all();

    // Load Twig.
    $loader = new FilesystemLoader(getcwd().DIRECTORY_SEPARATOR.'views');
    $twig = new Environment($loader, [
        'cache' => getcwd().DIRECTORY_SEPARATOR.'cache',
    ]);

    // Render the form.
    echo $twig->render('form.html', [
        'categories' => $categories,
    ]);
}
