<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/doctorsearch.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    echo "Wrong method";
    return;
}

session_start();

$database = Database::getInstance();
$db = $database->getConnection();

$doctorsearch = new DoctorSearch($db);
$specialty = $_POST['doc_specialty'];
$city = $_POST['doc_city'];
$area = $_POST['dr-area'];
$name = $_POST['dr_name'];

$specialty = preg_replace("/[^a-z0-9]/i", "", $specialty);
$area = preg_replace("/[^a-z0-9]/i", "", $area);
$city = preg_replace("/[^a-z0-9]/i", "", $city);
$name = preg_replace("/[^a-z0-9]/i", "", $name);
$name = strtolower($name);

$data = array(
    "name" => $name,
    "specialty" => $specialty,
    "area" => $area,
    "city" => $city,
);
$data = $doctorsearch->searchDoctors(name: $name, city: $city, area: $area, specialty: $specialty);

$_SESSION['searchResults'] = $data;
header("Location: ../../searchResults.php?name=$name&city=$city&area=$area&specialty=$specialty");
exit();

// echo "<pre>";
// print_r($data);
// echo "</pre>";