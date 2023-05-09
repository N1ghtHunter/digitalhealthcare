<?php
include_once "../objects/doctor.php";
include_once "../config/database.php";
// Connect to the database
$db = Database::getInstance();
$conn = $db->getConnection();
$hospital = new Hospital($conn);
// Insert data into the table
if (isset($_POST["name"]) && isset($_POST["address"]) && isset($_POST["phone_number"]) && isset($_POST["doctor_id"])) {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];
    $doctor_id = $_POST["doctor_id"];
    $clinic->addHospital($name, $address, $phone_number, $doctor_id)
}

// Close the database connection
mysqli_close($conn);
?>