<?php 
session_start();
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['role'] != 'patient' || !isset($_SESSION['id'])) {
//     header("Location: ../../login.php?error=unauthorized");
//     exit();
// }
// if user is not logged in , set logged_in to false
include_once "../api/objects/doctor.php";
include_once "../api/config/database.php";
$database = new Database();
$db = $database->getConnection();
$doctor = new Doctor($db);

$id;
$user;
$role;
$logged_in;
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    $_SESSION['logged_in'] = false;
    header("Location: login.php");
} else if ($_SESSION['logged_in'] == true && $_SESSION['role'] == "doctor") {
    $id = $_SESSION['id'];
    $user = $_SESSION['doctor'];
    $role = $_SESSION['role'];
    $logged_in = $_SESSION['logged_in'];
}

$user = $doctor->readOne(1);
unset($user['password']);
//print_r($user);
?>


<!DOCTYPE html>
<html>
<head>
	<title >Update Profile</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/view.css">
</head>
<body>
  
	<div class="container mt-5">
		<h2 style=" text-align:center;" >Update Profile</h2>
		<form action="api/patient/update.php" method="post">
        
            <div class="form-group">
				<label >ID</label>
                <input type="" name="doctor_id"   value="<?php echo $user['id']; ?>" disabled>
            </div>

            <div class="form-group">
				<label >First Name</label>
				<input type="text" name="first_name"  value="<?php echo $user['first_name']; ?>" disabled>
			</div>
            <div class="form-group">
				<label >Last Name</label>
				<input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" disabled>
			</div>
            <div class="form-group">
				<label >Email</label>
				<input type="text" name="email"  value="<?php echo $user['email']; ?>" disabled>
			</div>
            <div class="form-group">
				<label >Phone Number</label>
				<input type="phone_number" name="phone_number"  value="<?php echo $user['phone_number']; ?>" required>
			</div>
            <div class="form-group">
                <label >Gender</label>
				<input type="text" name="gender"   value="<?php echo $user['gender']; ?>" disabled >
			</div>
            <div class="form-group">
                <label >specialty</label>
				<input type="text" name="specialty"   value="<?php echo $user['specialty']; ?>" required >
			</div>
			<div class="form-group">
				<label >state</label>
				<input type="text" name="state"  value="<?php echo $user['state']; ?>" required>
			</div>
			<div class="form-group">
				<label >area</label>
				<input type="text" name="area"  value="<?php echo $user['area']; ?>" required>
			</div>
			<div class="form-group">
				<label >years_of_exp</label>
				<input type="number" name="years_of_exp"  value="<?php echo $user['years_of_exp']; ?>" required>
			</div>
            <div class="form-group">	
                <label >allow_online_payment</label>
				<input type=""  name="allow_online_payment"  value="<?php echo $user['allow_online_payment']; ?>" required>

			</div>
            <div class="form-group">	
                <label >allow_insurance</label>
				<input type="text"    name="allow_insurance"  value="<?php echo $user['allow_insurance']; ?>" required>

			</div>
            
             
			
			<button type="submit">Update Profile</button>
		</form>
	</div>

</body>
</html>