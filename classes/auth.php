<?php

function require_login() {
    if (!isset($_SESSION['login'])) {
        header("Location: /login.php"); // replace with your login page URL
        exit();
    }
}
