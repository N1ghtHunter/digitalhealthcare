<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/appointment.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo "Wrong method";
    return;
}

session_start();

$database = Database::getInstance();
$db = $database->getConnection();

$appointment = new Appointment($db);
$place = $_POST['place'];
$cost = $_POST['cost'];
$date = $_POST['date'];
$start_date = $_POST['start_time'];
$end_date = $_POST['end_time'];
$dr_id = $_SESSION['id'];
echo $place;
$clinic = new Appointment($db);
$id_clinic = $clinic->selectClinicIdByName($place);
$id_hospital = $clinic->selectHospitalIdByName($place);

if ($appointment->AddAppointment($date, $dr_id, $start_date, $end_date, $cost, clinic_id: $id_clinic, hospital_id: $id_hospital)) {

    $_SESSION["add_appointment_success"] = true;
    header("Location: ../../doctor/home.php ");
    exit();
} else {
    $_SESSION["add_appointment_success"] = false;
    header("Location: ../../doctor/home.php ");
    exit();
}
