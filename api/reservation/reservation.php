<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../objects/reservation.php';
include_once '../objects/doctor.php';
include_once '../objects/payment.php';
include_once '../shared/insurance.php';
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


$reservation = new Reservation($db);
$doctor = new Doctor($db);
$insurance = new Insurance($db);
$payment = new Payment($db);

$id;
$user;
$role;
$logged_in;
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['role'] != "patient" || !isset($_SESSION['patient']) || !$_SESSION['patient']) {
    $_SESSION['logged_in'] = false;
    header("Location: http://localhost/login.php");
} else if ($_SESSION['logged_in'] == true && $_SESSION['role'] == "patient") {
    $id = $_SESSION['patient']['id'];
    $user = $_SESSION['patient'];
    $role = $_SESSION['role'];
    $logged_in = $_SESSION['logged_in'];
}



// get post params
$start_time = $_POST['start_time'];
// remove  From   and spaces
$start_time = str_replace("From", "", $start_time);
$start_time = str_replace(" ", "", $start_time);
$end_time = $_POST['end_time'];
$end_time = str_replace("To", "", $end_time);
$end_time = str_replace(" ", "", $end_time);
$date = $_POST['date'];
// remove on from date and spaces
$date = str_replace("On", "", $date);
$date = str_replace(" ", "", $date);
// convert date to mysql format
$date = date("Y-m-d", strtotime($date));
$doctor_id = $_POST['doctor_id'];
$clinic_id = '';
if (isset($_POST['clinic_id']))
    $clinic_id = $_POST['clinic_id'];

$hospital_id = '';
if (isset($_POST['hospital_id']))
    $hospital_id = $_POST['hospital_id'];
$cost = $_POST['cost'];
// get the numbers only from cost
$cost = preg_replace('/[^0-9]/', '', $cost);
// convert it to int
$cost = (int) $cost;
$insurance_info = '';
$insurance_info = $_SESSION['patient']['insurance_info'];

$patient_id = $_POST['patient_id'];
$payment_method = $_POST['payment_method'];
//  put them in array
$data = array(
    "patient_id" => $id,
    "start_time" => $start_time,
    "end_time" => $end_time,
    "date" => $date,
    "doctor_id" => $doctor_id,
    "cost" => $cost,
    "insurance_info" => $insurance_info,
);
if (!empty($clinic_id)) {
    $data['clinic_id'] = $clinic_id;
}
if (!empty($hospital_id)) {
    $data['hospital_id'] = $hospital_id;
}
// echo "<pre>";
// print_r($data);
// echo "</pre>";

$docData = $doctor->readone($doctor_id);
$allow_insurance = $docData['allow_insurance'];
$allow_online_payment = $docData['allow_online_payment'];
// print_r($row);
// $full_name = $user['first_name'] . " " . $user['last_name'];

if ($allow_insurance == true && $insurance_info != null && $insurance_info != "") {
    $discount = $insurance->getDiscountByName($insurance_info);
    // discount is number 0 and 100 
    $cost = $cost - ($cost * $discount / 100);
    $data['cost'] = $cost;
    $data['insurance_info'] = $insurance_info;
    $data['discount'] = $discount;
}

if ($payment_method == 'cash') {
    $payment_id = $payment->createCash($cost, $id);
    //	id	date	start_time	end_time	doctor_id	patient_id	clinic_id	hospital_id	payment_id
    // use clinic_id or hospital_id use the one that is not empty
    // the function header is AddReservation($start_time, $end_time, $doctor_id, $patient_id, $payment_id, $clinic_id = "", $hospital_id = "")
    $reservation_id = $reservation->AddReservation($date, $start_time, $end_time, $doctor_id, $id, $payment_id, $clinic_id, $hospital_id);
    if ($reservation_id != -1) {
        $patient = new Patient($db);
        $patient->sendReservationConfirmation($id, $date, $start_time, $end_time, $cost);
        http_response_code(200);
        $_SESSION['message'] = "Reservation successful!";
        header("Location: http://localhost/payment/payment-confirmation.php");
    } else {
        http_response_code(503);
        $_SESSION['message'] = "Reservation failed!";
        header("Location: http://localhost/payment/payment-confirmation.php");
    }
} else {
    if ($allow_online_payment == true && $payment_method == 'online') {
        $reservationData = array(
            "date" => $date,
            "start_time" => $start_time,
            "end_time" => $end_time,
            "doctor_id" => $doctor_id,
            "patient_id" => $id,
            "clinic_id" => $clinic_id,
            "hospital_id" => $hospital_id,
            "cost" => $cost,
        );
        $_SESSION['reservationData'] = $reservationData;
        header("Location: http://localhost/payment/payment.php");
    } else {
        http_response_code(503);
        $_SESSION['message'] = "Reservation failed!";
        header("Location: http://localhost/payment/payment-confirmation.php");
    }
}
