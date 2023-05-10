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
$app_id = $_POST["delete_app"];
if ($appointment->deleteAppointment($app_id)) {

    $_SESSION["delete_appointment_success"] = true;
    header("Location: ../../doctor/home.php ");
    exit();
} else {
    $_SESSION["delete_appointment_success"] = false;
    header("Location: ../../doctor/home.php ");
    exit();
}
