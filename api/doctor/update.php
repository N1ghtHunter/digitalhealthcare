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
$database = new Database();
$db = $database->getConnection();

$doctor = new Doctor($db);
$id = $_SESSION['doctor']['id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$gender = $_POST['gender'];
$specialty = $_POST['specialty'];
$state = $_POST['state'];
$area = $_POST['area'];
$years_of_exp = $_POST['years_of_exp'];
$allow_online_payment = $_POST['allow_online_payment'];
$allow_insurance = $_POST['allow_insurance'];
$password = $_POST['password'];