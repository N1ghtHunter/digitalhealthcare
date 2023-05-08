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
$database = new Database();
$db = $database->getConnection();
$appointment = new Appointment($db);

if ($appointment->deleteAllAppointment(1)) {

    $_SESSION["delete_all_appointment_success"] = true;
    header("Location: ../../doctor/makeappointment.php ");
    exit();
} else {
    $_SESSION["delete_all_appointment_success"] = false;
    header("Location: ../../doctor/makeappointment.php ");
    exit();
}
