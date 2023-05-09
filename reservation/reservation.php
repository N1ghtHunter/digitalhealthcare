
<?php
session_start();

$id;
$user;
$role;
$logged_in;
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['role'] != "patient") {
    $_SESSION['logged_in'] = false;
    header("Location: http://localhost/login.php");
} else if ($_SESSION['logged_in'] == true && $_SESSION['role'] == "patient") {
    $id = $_SESSION['id'];
    $user = $_SESSION['patient'];
    $role = $_SESSION['role'];
    $logged_in = $_SESSION['logged_in'];
}
// get query params
$start_time = $_GET['start_time'];
$end_time = $_GET['end_time'];
$date = $_GET['date'];
$doctor_id = $_GET['doctor_id'];
$clinic_id = '';
if (isset($_GET['clinic_id']))
    $clinic_id = $_GET['clinic_id'];

$hospital_id = '';
if (isset($_GET['hospital_id']))
    $hospital_id = $_GET['hospital_id'];
$cost = $_GET['cost'];
$insurance = $_SESSION['patient']['insurance_info'];
$allow_online_payment = $_GET['allow_online_payment'];
$allow_insurance = $_GET['allow_insurance'];

//  put them in array
$data = array(
    "patient_id" => $id,
    "start_time" => $start_time,
    "end_time" => $end_time,
    "date" => $date,
    "doctor_id" => $doctor_id,
    "cost" => $cost,
    "insurance" => $insurance,
    "allow_online_payment" => $allow_online_payment,
    "allow_insurance" => $allow_insurance,
);
if (!empty($clinic_id)) {
    $data['clinic_id'] = $clinic_id;
}
if (!empty($hospital_id)) {
    $data['hospital_id'] = $hospital_id;
}
echo "<pre>";
print_r($data);
echo "</pre>";
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Reservation Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
    </head>
    <body> 
        
        <section class = "banner">
            <h2>BOOK AN APPOINTMENT NOW</h2>
            <div class = "card-container">
                <div class = "card-img">
                    <!-- image here -->
                </div>

                <div class = "card-content">
                    <h3>Reservation</h3>
                    <form>
                        <div class = "form-row">
                        <!-- <input type="radio1" id="pay cash" name="payment _method" value="pay cash">
                            <label for="html">PAY CASH</label><br>
                            <input type="radio2" id="pay online" name="payment_method" value="pay online">
                            <label for="css">PAY ONLINE</label><br>
                         -->
                            <input type = "text" placeholder="Full Name">
                            <input type = "text" placeholder="Phone Number">
                        </div>

                        <div class = "form-row">
                            <input type = "text" placeholder="Start/End Time">
                            <input type = "text" placeholder="Price">
                        </div>

                        <div class = "form-row">
                            <input type = "text" placeholder="Location"><br>
                        </div>

                        <div class = "form-row">
                            <label class="container">PAY CASH
                            <input type="radio" checked="checked" name="radio">
                            <span class="checkmark"></span>
                            </label>
                            <label class="container">PAY ONLINE
                            <input type="radio" name="radio">
                            <span class="checkmark"></span>
                            </label>
                        </div>    

                        <div class = "form-row"> 
                            <input type = "submit" value = "CONFIRM RFESERVATION">
                        </div>
                    </form>
                </div>
            </div>
        </section>
        
    </body>
</html>