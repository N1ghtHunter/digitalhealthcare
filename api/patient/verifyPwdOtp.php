<?php
session_start();
include_once '../objects/patient.php';
include_once '../config/database.php';
// get input-1 to input-6 from post request
// if not post request, redirect to verify.php
if (!isset($_POST['input-1'])) {
    header('Location: ../../verify.php');
    exit();
}
$input1 = $_POST['input-1'];
$input2 = $_POST['input-2'];
$input3 = $_POST['input-3'];
$input4 = $_POST['input-4'];
$input5 = $_POST['input-5'];
$input6 = $_POST['input-6'];

// compine all inputs

$otp = $input1 . $input2 . $input3 . $input4 . $input5 . $input6;

// get email and otp from session

$email = $_SESSION['email'];
// check if otp is correct
$database = new Database();
$db = $database->getConnection();
$patient = new Patient($db);

$id = $patient->verifyRecoverPwdOtp($otp, $email);
if ($id == -1) {
    // if otp is incorrect, redirect to verify.php
    $_SESSION['error'] = "OTP is incorrect";
    header('Location: ../../recoverPwdVerify.php');
} else {
    session_unset();
    $_SESSION['id'] = $id;
    header("Location: ../../reset-password.php");
    exit();
}
