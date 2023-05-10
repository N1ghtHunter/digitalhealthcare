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
$id = $_SESSION['patient']['id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone_number = $_POST['phone_number'];
$insurance_info = $_POST['insurance_info'];
$date_of_birth = $_POST['date_of_birth'];

if (empty($first_name) || empty($last_name) || empty($phone_number) || empty($insurance_info) || empty($date_of_birth)) {
    header("Location: ../../viewprofile.php");
    exit();
}

$patient->update($id, $first_name, $last_name, $phone_number, $insurance_info, $date_of_birth);
$_SESSION['patient'] = $patient->readOne($id);
header("Location: ../../viewprofile.php");
exit();
