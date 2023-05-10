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
$database = Database::getInstance();
$db = $database->getConnection();

$request = new Doctor($db);
$doc_id = $_POST["deldoc"];
if ($request->deleteDoctor($doc_id)) {

    $_SESSION["delete_doctor_success"] = true;
    header("Location: ../../admin/showdoctors.php");
    exit();
} else {
    $_SESSION["delete_doctor_success"] = false;
    header("Location: ../../admin/showdoctors.php");
    exit();
}
