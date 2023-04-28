<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/patient.php';

// make endpoint to read single patient

$database = new Database();
$db = $database->getConnection();

$patient = new Patient($db);

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;

$result = $patient->readOne($id);

if ($result) {
    http_response_code(200);
    echo json_encode($result);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Patient not found"));
}
