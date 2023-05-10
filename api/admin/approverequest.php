<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/request.php';
include_once '../objects/doctor.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo "Wrong method";
    return;
}

session_start();
$database = Database::getInstance();
$db = $database->getConnection();

$request = new Request($db);
$doctor = new Doctor($db);
$req_id = $_POST["approve"];
$doctor_id = $_POST["doctor_id"];
if ($request->ApproveRequest($req_id)) {
    $dr = $doctor->readOne($doctor_id);
    $doctor->sendApproveEmail($dr);
    $_SESSION["approve_request_success"] = true;
    header("Location: ../../admin/request.php");
    echo json_encode(array("message" => "success"));
    exit();
} else {
    $_SESSION["approve_request_success"] = false;
    header("Location: ../../admin/request.php");
    exit();
}
