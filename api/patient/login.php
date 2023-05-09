<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/patient.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo "Wrong method";
    return;
}
session_start();

$database = new Database();
$db = $database->getConnection();

$patient = new Patient($db);
$email = $_POST['email'];
$password = $_POST['password'];

$_SESSION['email'] = $email;

if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Fill all the required fields";
    header("Location: ../../login.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['email_error'] = "Invalid email format";
    header("Location: ../../login.php");
    exit();
}
$data = array(
    "email" => $email,
    "password" => $password
);

// print_r($data);
$result = $patient->login($data);
print_r($result);
if ($result == false) {
    $_SESSION['error'] = "Wrong email or password";
    header("Location: ../../login.php");
    exit();
} else {
    session_unset();
    $_SESSION['patient'] = $result;
    $_SESSION['logged_in'] = true;
    $_SESSION['role'] = "patient";
    $_SESSION['id'] = $result['id'];
    header("Location: ../../home.php");
    exit();
}
