<?php
include 'inc/functions.inc.php';
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve email and password from POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the login function
    $result = loginUser($email, $password);

    if ($result === 'success') {
        header('Location: index.php');
    } else {
        header('Location: login.php?error=' . urlencode($result));
    }
}
