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
$pwdRegEx = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%#*?&]{8,}$/";

$database = new Database();
$db = $database->getConnection();

$patient = new Patient($db);
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$gender = $_POST['gender'];
$insurance_info = $_POST['insurance_info'];
$age = $_POST['age'];
$blood_type = $_POST['blood_type'];
$date_of_birth = $_POST['date_of_birth'];
$password = $_POST['password'];

$_SESSION['first_name'] = $first_name;
$_SESSION['last_name'] = $last_name;
$_SESSION['email'] = $email;
$_SESSION['phone_number'] = $phone_number;
$_SESSION['age'] = $age;
$_SESSION['gender'] = $gender;
$_SESSION['insurance_info'] = $insurance_info;
$_SESSION['blood_type'] = $blood_type;
$_SESSION['date_of_birth'] = $date_of_birth;


if (empty($first_name) || empty($last_name) || empty($email) || empty($phone_number) || empty($gender) || empty($age) || empty($date_of_birth) || empty($password)) {
    $_SESSION['error'] = "Fill all the required fields";
    header("Location: ../../index.php");
    exit();
}

if (!preg_match("/^[a-zA-Z-' ]*$/", $first_name) || !preg_match("/^[a-zA-Z-' ]*$/", $last_name)) {
    $_SESSION['name_error'] = "Only letters allowed";
    header("Location: ../../index.php");
    exit();
}

if (!preg_match($pwdRegEx, $password)) {
    $_SESSION['password_error'] = "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter and one number";
    header("Location: ../../index.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['email_error'] = "Invalid email format";
    return;
}


// hash the password
$password_hash = password_hash($password, PASSWORD_BCRYPT);


// PUT ALL OF THEM IN AN ARRAY

// Create a JSON object containing the patient's information
$data = array(
    "first_name" => $first_name,
    "last_name" => $last_name,
    "email" => $email,
    "phone_number" => $phone_number,
    "gender" => $gender,
    "insurance_info" => $insurance_info,
    "age" => $age,
    "blood_type" => $blood_type,
    "date_of_birth" => $date_of_birth,
    "password" => $password_hash
);

$exists = $patient->emailExists($email);

if ($exists) {
    $_SESSION['email_error'] = "Email already exists";
    header("Location: ../../index.php");
    exit();
}



try {
    $result = $patient->create($data);
    if ($result !== -1) {
        $_SESSION['success'] = "Patient created successfully";
        $_SESSION['id'] = $result;
        $_SESSION['logged_in'] = true;
        $_SESSION['role'] = "patient";
        header("Location: ../../home.php");
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong";
        header("Location: ../../index.php");
        exit();
    }
} catch (\Throwable $th) {
    $_SESSION['error'] = "Something went wrong";
    header("Location: ../../index.php");
    exit();
}
