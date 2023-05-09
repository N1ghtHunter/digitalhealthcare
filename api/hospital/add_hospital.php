<?php
include_once "../objects/hospital.php";
include_once "../config/database.php";
session_start();
// Connect to the database
$db = Database::getInstance();
$conn = $db->getConnection();
$hospital = new Hospital($conn);
// Insert data into the table
if (isset($_POST["name"]) && isset($_POST["address"]) && isset($_POST["phone_number"]) && isset($_POST["doctor_id"])) {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];
    $doctor = $_SESSION['doctor'];
    $doctor_id = $doctor['id'];
    $hospital->addHospital($name, $address, $phone_number, $doctor_id);
    header("Location: http://localhost/doctor/hospital.php");
} else {
    header("Location: http://localhost/doctor/login.php");
}
