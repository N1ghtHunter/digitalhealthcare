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

$request = new Patient($db);
$pat_id = $_POST["delpat"];
if ($request->deletePatient($pat_id)) {

    $_SESSION["delete_patient_success"] = true;
    header("Location: ../../admin/showpatient.php");
    exit();
} else {
    $_SESSION["delete_patient_success"] = false;
    header("Location: ../../admin/showpatient.php");
    exit();
}
