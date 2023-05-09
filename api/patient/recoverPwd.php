<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

session_start();
include_once '../objects/patient.php';
include_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo "Wrong method";
    return;
}


$database = Database::getInstance();
$db = $database->getConnection();

$patient = new Patient($db);
$email = $_POST['email'];

if (empty($email)) {
    $_SESSION['error'] = "Fill all the required field";
    header("Location: ../../forget-password.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['email_error'] = "Invalid email format";
    header("Location: ../../forget-password.php");
    exit();
}

if (!$patient->emailExists($email)) {
    $_SESSION['email_error'] = "Email does not exist";
    header("Location: ../../forget-password.php");
    exit();
}

$otp = $patient->generateOTP($email);

if (!$otp) {
    $_SESSION['error'] = "OTP generation failed";
    header("Location: ../../forget-password.php");
    exit();
}

$email_res = $patient->sendRecoverPassword($otp, $email);

if (!$email_res) {
    $_SESSION['error'] = "OTP sending failed";
    header("Location: ../../forget-password.php");
    exit();
}

$_SESSION['otp'] = $otp;
$_SESSION['email'] = $email;
header("Location: ../../recover-password.php");
