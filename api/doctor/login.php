<?php
session_start(); 

include_once '../config/database.php';
include_once '../objects/doctor.php';

echo '<link rel="stylesheet" type="text/css" href="../../doctor/style.css">';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $doctor = new doctor ($db);
    // Get the username and password from the form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $data = array('email'=> $email , 'password' => $password);
    $result = $doctor->login($data);

if($result == false)
{

       $_SESSION['error'] = "Email or password is incorrect";      
         header("Location: http://localhost/doctor/login.php");
         exit(); 
    

} 
 
else 
{
   
     $_SESSION['id'] = $result -> id ;
     $_SESSION['logged_in'] = true;
     $_SESSION['role'] = "doctor";
     header("Location: ../../home.php");
         exit();
    
}

   
}


?>

