<?php
use \App\Helpers;
use \App\Models\Category;
use App\Models\ContactForm;

require_once('../vendor/autoload.php');

$db = Helpers::db_connect();

// Instantiate the Category model as it is used in both the GET and POST.
$category = new Category($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the POST request
    $success = false;
    $input = $_POST;

    $errors = [];

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
    $category = new Category($db);
    $category = $category->find($categoryId);

    if ($category === false) {
        $errors['categoryId'] = "Please select a Category";
    }

    if($email === false) {
        $errors['email'] = "Please provide a valid email address";
    }

    if(empty($errors)) {
        // Insert the new record.
        $form = new ContactForm($db);
        $success = $form->insert($categoryId, $email, $orderNumber, $firstName, $lastName, $phoneNo, $comment);
    }

    echo json_encode([
        'success' => $success,
        'errors' => $errors,
    ]);
} else {
    // Handle GET request

    // Get the list of all categories
    $categories = $category->all();

    // Show the form
    include_once 'form.php';
}
