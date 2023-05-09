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
$id = $_SESSION['patient']['id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone_number = $_POST['phone_number'];
$gender = $_POST['gender'];
$insurance_info = $_POST['insurance_info'];
$age = $_POST['age'];
$blood_type = $_POST['blood_type'];
$password = $_POST['password'];
