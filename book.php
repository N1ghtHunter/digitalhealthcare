<?php

session_start();
include_once 'api/objects/doctor.php';
include_once 'api/objects/reservation.php';

include_once 'api/config/database.php';
/* include_once 'api/reservation/reservation.php';
 */$id;
$user;
$role;
$logged_in;
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['role'] != "patient" || !isset( $_SESSION['patient']) ||!$_SESSION['patient'] ) {
    $_SESSION['logged_in'] = false;
    header("Location: http://localhost/login.php");
} else if ($_SESSION['logged_in'] == true && $_SESSION['role'] == "patient") {
    $id = $_SESSION['patient']['id'];
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


$patient_id = $_GET['patient_id'];
$payment_id = $_SESSION['payment_id'];


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
/* print_r($data);
 */echo "</pre>";

$database = new Database();
$db = $database->getConnection();
$doctor = new Doctor($db);

$row = $doctor->readone($doctor_id);
/* print_r ($row) ;
 */
$full_name = $user['first_name']. " " .$user['last_name'];


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Reservation Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="main.css">
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
                    <form action="api/reservation/reservation.php" >
                        <div class = "form-row">
                        <!-- <input type="radio1" id="pay cash" name="payment _method" value="pay cash">
                            <label for="html">PAY CASH</label><br>
                            <input type="radio2" id="pay online" name="payment_method" value="pay online">
                            <label for="css">PAY ONLINE</label><br>
                         -->
                            <input type = "text" placeholder="Full Name" value="<?php echo $full_name ;?>" readonly>
                            <input type = "text" placeholder="Phone Number" value = "<?php echo $user ['phone_number']; ?> " readonly>
                        </div>

                        <div class = "form-row">
                            <input type = "text" name="start_time" value = " From  <?php echo $start_time; ?> " readonly >
                            <input type = "text" name ="end_time" placeholder="End Time" value = " To  <?php echo $end_time; ?> " readonly>
                        </div>

                        <div class = "form-row">
                            <input type = "text" placeholder="Price" value = " Cost : <?php echo $cost; ?> LE" readonly><br>
                        </div>

                        <input type ="text" name="doctor_id" value = "<?php echo $doctor_id ;?>" style="display:none;">
                        <input type ="text" name="patient_id" value = "<?php echo $patient_id ;?>" style="display:none;">
                        <input type ="text" name="clinic_id" value = "<?php echo $clinic_id ;?>" style="display:none;">
                        <input type ="text" name="hospital_id" value = "<?php echo $hospital_id ;?>" style="display:none;">
                        <input type ="text" name="payment_id" value = "<?php echo $payment_id ;?>" style="display:none;">




                        <div class = "form-row">
                            <select name = "Inssurance" onclick ="checkInsurance()" >
                                <option value = "Inssurance-select">Select Insurance</option>
                                <option value = "Inssurance 1">AXA Egypt Insurance</option>
                                <option value = "Inssurance 2">Arab Misr Insurance</option>
                                <option value = "Inssurance 3"> Misr Insurance</option>
                                <option value = "Inssurance 4">Egyptian Takaful Insurance</option>
                             
                            </select>
                        </div>
                        <div class = "form-row">
                            <label class="container">PAY CASH
                            <input type="radio" checked="checked" name="payment_method" value="cash" id= "pay_cash">
                            <span class="checkmark"></span>
                            </label>
                        
                            <label class="container" >PAY ONLINE
                            <input type="radio" name="payment_method" value = "online" onclick = "checkPayment()" >
                            <span class="checkmark"></span>
                            </label>


                            

                            
<script>




var ALERT_TITLE = "";
var ALERT_BUTTON_TEXT = "Ok";

if(document.getElementById) {
	window.alert = function(txt) {
		createCustomAlert(txt);
	}
}

function createCustomAlert(txt) {
	d = document;

	if(d.getElementById("modalContainer")) return;

	mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
	mObj.id = "modalContainer";
	mObj.style.height = d.documentElement.scrollHeight + "px";
	
	alertObj = mObj.appendChild(d.createElement("div"));
	alertObj.id = "alertBox";
	if(d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
	alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth)/2 + "px";
	alertObj.style.visiblity="visible";

	h1 = alertObj.appendChild(d.createElement("h1"));
	h1.appendChild(d.createTextNode(ALERT_TITLE));

	msg = alertObj.appendChild(d.createElement("p"));
	//msg.appendChild(d.createTextNode(txt));
	msg.innerHTML = txt;

	btn = alertObj.appendChild(d.createElement("a"));
	btn.id = "closeBtn";
	btn.appendChild(d.createTextNode(ALERT_BUTTON_TEXT));
	btn.href = "#";
	btn.focus();
	btn.onclick = function() { removeCustomAlert();return false; }

	alertObj.style.display = "block";
	
}

function removeCustomAlert() {
	document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
}
function ful(){
alert('Alert this pages');
} 





function checkPayment() {
<?php
$allow_online_payment = $_GET['allow_online_payment'];

if ($allow_online_payment == 'false') {

 echo "alert('SORRY , Online payment is not allowed for this doctor.');";
 echo "document.getElementById('pay_cash').click()";

} else {
}
?>
}


function checkInsurance() {
<?php
$allow_insurance = $_GET['allow_insurance'];

if ($allow_insurance == 'false') {

 echo "alert('SORRY , This doctor doesnt accept insurances.');";
 echo "document.getElementById('pay_cash').click()";

} else {

}
?>
}




document.querySelector('form').addEventListener('submit', function(event) {
  var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
  if (paymentMethod === 'cash') {
    alert('Reservation confirmed. Payment will be made with cash.');
  }
});

</script>

 
                        </div>    
                        

                        <div class = "form-row"> 
                            <input type = "submit" value = "CONFIRM RFESERVATION" actiom >
                            
                        </div>

                      
                    </form>
                </div>
            </div>
        </section>
        
    </body>
</html>