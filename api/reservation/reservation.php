<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../objects/reservation.php';
include_once '../objects/doctor.php';
include_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo "Wrong method";
    return;
}
session_start();
$database = new Database();
$db = $database->getConnection();

$reservation = new Reservation($db);
$doctor = new Doctor($db);


$id;
$user;
$role;
$logged_in;
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['role'] != "patient" || !isset( $_SESSION['patient']) ||!$_SESSION['patient'] ) {
    $_SESSION['logged_in'] = false;
    header("Location: http://localhost/login.php");
} else if ($_SESSION['logged_in'] == true && $_SESSION['role'] == "patient") {
    $id = $_SESSION['patient']['id'];
    $user = $_SESSION['patient'];
    $role = $_SESSION['role'];
    $logged_in = $_SESSION['logged_in'];
}
// get query params
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$date = $_POST['date'];
$doctor_id = $_POST['doctor_id'];
$clinic_id = '';
if (isset($_POST['clinic_id']))
    $clinic_id = $_POST['clinic_id'];

$hospital_id = '';
if (isset($_POST['hospital_id']))
    $hospital_id = $_POST['hospital_id'];
$cost = $_POST['cost'];
$insurance = $_SESSION['patient']['insurance_info'];
$allow_online_payment = $_POST['allow_online_payment'];
$allow_insurance = $_POST['allow_insurance'];

$patient_id = $_POST['patient_id'];
$payment_id = $_SESSION['id'];

/* $payment_id = $_POST['payment_id'];
 */


//  put them in array
$data = array(
    "patient_id" => $id,
    "start_time" => $start_time,
    "end_time" => $end_time,
    "date" => $date,
    "doctor_id" => $doctor_id,
    "cost" => $cost,
    "insurance" => $insurance,
    "allow_online_payment" => $allow_online_payment,
    "allow_insurance" => $allow_insurance,
);
if (!empty($clinic_id)) {
    $data['clinic_id'] = $clinic_id;
}
if (!empty($hospital_id)) {
    $data['hospital_id'] = $hospital_id;
}
echo "<pre>";
print_r($data);
echo "</pre>";



$row = $doctor->readone($doctor_id);
print_r ($row) ;

$full_name = $user['first_name']. " " .$user['last_name'];


?>
