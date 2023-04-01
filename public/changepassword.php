<?php
// changepassword.php

session_start();
require_once __DIR__ . '/../bootstrap/bootstrap.php';

// handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get the current and new passwords from the form
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];


    // check that the new password is not empty
    if (!empty($newPassword)) {
        // update the password in the database
        $pdo = PDOProvider::get();
        $stmt = $pdo->prepare('UPDATE employee SET password = :password WHERE login = :login');
        $stmt->bindValue(':password', $newPassword);
        $stmt->bindValue(':login', $_SESSION['login']);
        $stmt->execute();

        // redirect to the index page
        header("Location: /index.php");
        exit();
    } else {
        // display an error message if the new password is empty
        $error = 'New password cannot be empty.';
    }
}

// render the password change form
$page = new ChangePasswordPage(isset($error) ? $error : null);
$page->render();
