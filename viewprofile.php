<?php
session_start();
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['role'] != 'patient' || !isset($_SESSION['id'])) {
//     header("Location: ../../login.php?error=unauthorized");
//     exit();
// }
// if user is not logged in , set logged_in to false
include_once "api/objects/patient.php";
include_once "api/config/database.php";
$database = new Database();
$db = $database->getConnection();
$patient = new Patient($db);

$id;
$user;
$role;
$logged_in;
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false) {
    $_SESSION['logged_in'] = false;
    header("Location: login.php");
} else if ($_SESSION['logged_in'] == true && $_SESSION['role'] == "patient") {
    $id = $_SESSION['id'];
    $user = $_SESSION['patient'];
    $role = $_SESSION['role'];
    $logged_in = $_SESSION['logged_in'];
}

$user = $patient->readOne(4);
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
    <link rel="stylesheet" type="text/css" href="css/view.css">
</head>
<body>
  
	<div class="container mt-5">
		<h2 style=" text-align:center;" >Update Profile</h2>
		<form action="api/patient/update.php" method="post">
        
            <div class="form-group">
				<label >ID</label>
                <input type="" name="user_id"   value="<?php echo $user['id']; ?>" disabled>
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
				<label >Phone Number</label>
				<input type="phone_number" name="phone_number"  value="<?php echo $user['phone_number']; ?>" required>
			</div>
            <div class="form-group">
				<label >Email</label>
				<input type="text" name="email"  value="<?php echo $user['email']; ?>" disabled>
			</div>
            <div class="form-group">
                <label >Gender</label>
				<input type="text" name="gender"   value="<?php echo $user['gender']; ?>" disabled >
			</div>
            <div class="form-group">
				<label >Date Of Birth</label>
				<input type="date" name="date_of_birth"  value="<?php echo $user['date_of_birth']; ?>" disabled>
			</div>
			<div class="form-group">
				<label >Age</label>
				<input type="number" name="age"  value="<?php echo $user['age']; ?>" required>
			</div>
			<div class="form-group">
				<label  name="insurance_info"  value="<?php echo $user['insurance_info']; ?>" required  >Insurance Information</label>
				<select default="Select Insurance">
                    <option>AXA Egypt Insurance </option>
                    <option>Arab Misr Insurance </option>
                    <option> Misr Insurance</option>
                    <option>Egyption Takaful Insurance</option>
                </select>
			</div>
			<div class="form-group">
				<label name="blood_type"  value="<?php echo $user['blood_type']; ?>" required >Blood Type</label>
                <select>
                    <option>A</option>
                    <option>A+</option>
                    <option>A-</option>
                    <option>B</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>AB</option>
                    <option>O</option>
                    <option>O+</option>
                    <option>O-</option>
                </select>
                </lable>
			</div>
			
			<button type="submit">Update Profile</button>
		</form>
	</div>

</body>
</html>