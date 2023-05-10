<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/doctor.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo "Wrong method";
    return;
}
session_start();
$database = Database::getInstance();
$db = $database->getConnection();

$doctor = new Doctor($db);
$id = $_SESSION['doctor']['id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone_number = $_POST['phone_number'];
$years_of_exp = $_POST['years_of_exp'];
$allow_online_payment = $_POST['allow_online_payment'];
$allow_insurance = $_POST['allow_insurance'];

if (empty($first_name) || empty($last_name) || empty($phone_number) || empty($years_of_exp) || empty($allow_online_payment) || empty($allow_insurance)) {
    header("Location: ../../doctor/viewprofile.php");
    exit();
}

$doctor->update($id, $first_name, $last_name, $phone_number, $years_of_exp, $allow_online_payment, $allow_insurance);
$_SESSION['doctor'] = $doctor->readOne($id);
header("Location: ../../doctor/viewprofile.php");
exit();
