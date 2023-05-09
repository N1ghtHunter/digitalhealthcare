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

$database = Database::getInstance();
$db = $database->getConnection();

$patient = new Patient($db);
$password = $_POST['password'];

if (empty($password)) {
    $_SESSION['error'] = "Fill all the required fields";
    header("Location: ../../reset-password.php");
    exit();
}

if ($_SESSION['id'] == null) {
    $_SESSION['error'] = "You are not logged in";
    header("Location: ../../reset-password.php");
    exit();
}

$password = password_hash($password, PASSWORD_BCRYPT);

$result = $patient->resetPassword($_SESSION['id'], $password);

if ($result == false) {
    $_SESSION['error'] = "Password reset failed";
    header("Location: ../../reset-password.php");
    exit();
}

$result = $patient->readOne($_SESSION['id']);

if ($result == -1) {
    $_SESSION['error'] = "Password reset failed";
    header("Location: ../../reset-password.php");
    exit();
} else {
    $_SESSION['patient'] = $result;
    $_SESSION['logged_in'] = true;
    $_SESSION['role'] = "patient";
    $_SESSION['id'] = $result['id'];
    header("Location: ../../home.php");
    exit();
}
