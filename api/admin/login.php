<?php
session_start();

include_once '../config/database.php';
include_once '../objects/Admin.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = Database::getInstance();
    $db = $database->getConnection();
    $admin = new Admin($db);
    // Get the username and password from the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $data = array('uname' => $username, 'pass' => $password);
    $result = $admin->login($data);

    if ($result == false) {

        $_SESSION['error'] = "Username or password is incorrect";
        header("Location: http://localhost/admin/login.php");
        exit();
    } else {

        $_SESSION['id'] = $result->id;
        $_SESSION['logged_in'] = true;
        $_SESSION['role'] = "admin";
        header("Location: ../../admin/home.php");
        exit();
    }
}
