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

$pwdRegEx = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%#*?&]{8,}$/";

$database = Database::getInstance();
$db = $database->getConnection();
$doctor = new Doctor($db);

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$state =  $_POST['state'];
$area =  $_POST['area'];
$gender = $_POST['gender'];
$phone_number = $_POST['phone_number'];
$specialty =  $_POST['specialty'];
$years_of_exp =  $_POST['years_of_exp'];
$allow_online_payment = $_POST['allow_online_payment'];
$allow_insurance = $_POST['allow_insurance'];

$_SESSION['first_name'] = $first_name;
$_SESSION['last_name'] = $last_name;
$_SESSION['email'] = $email;
$_SESSION['phone_number'] = $phone_number;
$_SESSION['gender'] = $gender;
$_SESSION['specialty'] = $specialty;
$_SESSION['state'] = $state;
$_SESSION['area'] = $area;
$_SESSION['years_of_exp'] = $years_of_exp;
$_SESSION['allow_insurance'] = $allow_insurance;
$_SESSION['allow_online_payment'] = $allow_online_payment;

if (empty($first_name) || empty($last_name) || empty($email) || empty($phone_number) || empty($gender)  || empty($specialty) || empty($area) || empty($state) || empty($allow_online_payment) || empty($password)) {
    $_SESSION['error'] = "Fill all the required fields";
    header("Location: ../../doctor/signup.php");
    exit();
}

if (!preg_match("/^[a-zA-Z-' ]*$/", $first_name) || !preg_match("/^[a-zA-Z-' ]*$/", $last_name)) {
    $_SESSION['name_error'] = "Only letters allowed";
    header("Location: ../../doctor/signup.php");
    exit();
}

if (!preg_match($pwdRegEx, $password)) {
    $_SESSION['password_error'] = "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter and one number";
    header("Location: ../../doctor/signup.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['email_error'] = "Invalid email format";
    header("Location: ../../doctor/signup.php");
    exit();
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
    "specialty" => $specialty,
    "state" => $state,
    "area" => $area,
    "years_of_exp" => $years_of_exp,
    "allow_insurance" => $allow_insurance,
    "allow_online_payment" => $allow_online_payment,
    "password" => $password_hash
);

$exists = $doctor->emailExists($email);

if ($exists) {
    $_SESSION['email_error'] = "Email already exists";
    header("Location: ../../doctor/signup.php");
    exit();
}



try {
    $result = $doctor->create($data);
    if ($result != -1) {
        session_unset();
        header("Location: ../../doctor/wait-for-approve.php");
        exit();
    } else {
        $_SESSION['error'] = "Something went wrong";
        header("Location: ../../doctor/signup.php");
        exit();
    }
} catch (\Throwable $th) {
    $_SESSION['error'] = "Something went wrong";
    echo $th;
    header("Location: ../../doctor/signup.php");
    exit();
}
