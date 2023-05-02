<?php
session_start();

$id;
$user;
$role;
$logged_in;
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['role'] != "patient") {
    $_SESSION['logged_in'] = false;
    header("Location: http://localhost/login.php");
} else if ($_SESSION['logged_in'] == true && $_SESSION['role'] == "patient") {
    $id = $_SESSION['id'];
    $user = $_SESSION['patient'];
    $role = $_SESSION['role'];
    $logged_in = $_SESSION['logged_in'];
}
// get query params
$start_time = $_GET['start_time'];
$end_time = $_GET['end_time'];
$date = $_GET['date'];
$doctor_id = $_GET['doctor_id'];
$clinic_id = '';
if (isset($_GET['clinic_id']))
    $clinic_id = $_GET['clinic_id'];

$hospital_id = '';
if (isset($_GET['hospital_id']))
    $hospital_id = $_GET['hospital_id'];
$cost = $_GET['cost'];
$insurance = $_SESSION['patient']['insurance_info'];
$allow_online_payment = $_GET['allow_online_payment'];
$allow_insurance = $_GET['allow_insurance'];

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
