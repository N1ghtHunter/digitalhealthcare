<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
session_start();

include_once '../config/database.php';
include_once '../objects/doctor.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = Database::getInstance();
    $db = $database->getConnection();
    $doctor = new doctor($db);
    // Get the username and password from the form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Fill all the required fields";
        header("Location: http://localhost/doctor/login.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: http://localhost/doctor/login.php");
        exit();
    }
    $data = array('email' => $email, 'password' => $password);
    $result = $doctor->login($data);

    if ($result == false) {
        $_SESSION['error'] = "Email or password is incorrect";
        header("Location: http://localhost/doctor/login.php");
        exit();
    }
    if ($result == -1) {
        $_SESSION['error'] = "Your Registration is still pending";
        header("Location: http://localhost/doctor/wait-for-approve.php");
        exit();
    } else {
        session_unset();
        $_SESSION['id'] = $result['id'];
        // store the whole doctor data in session
        $_SESSION['doctor'] = $result;
        $_SESSION['logged_in'] = true;
        $_SESSION['role'] = "doctor";
        header("Location: http://localhost/doctor/home.php");
        exit();
    }
} else {
    http_response_code(405);
    echo "Wrong method";
    return;
}
