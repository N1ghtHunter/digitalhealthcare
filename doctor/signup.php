<?php
session_start();


$first_name = '';
$last_name = '';
$email = '';
$phone_number = '';
$gender = '';
$specialty = '';
$state = '' ;
$area = '' ;
$years_of_exp = '';
$allow_online_payment ;
$allow_insurance ;
 
if (isset($_SESSION['first_name'])) {
    $firstname = $_SESSION['first_name'];
}
if (isset($_SESSION['last_name'])) {
    $lastname = $_SESSION['last_name'];
}
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}
if (isset($_SESSION['phone_number'])) {
    $phone_number = $_SESSION['phone_number'];
}
 
if (isset($_SESSION['gender'])) {
    $gender = $_SESSION['gender'];
} 
if (isset($_SESSION['specialty'])) {
    $specialty = $_SESSION['specialty'];
}
if (isset($_SESSION['state'])) {
    $state = $_SESSION['state'];
}
if (isset($_SESSION['area'])) {
    $area = $_SESSION['area'];
}
if (isset($_SESSION['years_of_exp'])) {
    $years_of_exp = $_SESSION['years_of_exp'];
}
if (isset($_SESSION['allow_insurance'])) {
    $allow_insurance = $_SESSION['allow_insurance'];
}
if (isset($_SESSION['allow_online_payment'])) {
    $allow_online_payment = $_SESSION['allow_online_payment'];
}
?>


<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Formicon-Flat Forms Pack</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="icons/styles.css">
		<link rel="stylesheet" href="css/bootstrap-custom.css">
		<link rel="stylesheet" href="style2.css">

		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,600' rel='stylesheet' type='text/css'>
		
	</head>
	<body>
		<!-- Register Form -->
		<div class="form-wrapper"> <!-- Form-wrapper only for positioning -->
			<form action="../api/doctor/signup.php" method="post" class="fcorn-register container">
				<p class="register-info">Welcome to the doctor SIGN UP page.</p>
				<div class="row">
					<p class="col-md-6"><input type="text" name="first_name" placeholder="First Name" value="<?php echo $first_name; ?>" required></p>
					<p class="col-md-6"><input type="text"  name="last_name" placeholder="Last Name"value="<?php echo $last_name; ?>" required></p>   
				</div>

                <?php if (isset($_SESSION['name_error'])) { ?>
                <p class="error"><?php echo $_SESSION['name_error']; ?></p>
                <?php
                    unset($_SESSION['name_error']);
                 } ?>
                
				<p><input type="email" name = "email" placeholder="Email Address"  value="<?php echo $email; ?>"required></p>

                <?php if (isset($_SESSION['email_error'])) { ?>
                <p class="error"><?php echo $_SESSION['email_error']; ?></p>
                <?php
                    unset($_SESSION['email_error']);
                 } ?>

				<p><input type="password" name="password" placeholder="Password" required>
				</p>

                <?php if (isset($_SESSION['password_error'])) { ?>
    <p class="error"><?php echo $_SESSION['password_error']; ?></p>
    <?php
        unset($_SESSION['password_error']);
    } ?>
				
				<div class="row">
                <div class="row">
					<p class="col-md-6"><input type="text" name = "state" placeholder="State"  value="<?php echo $state; ?>" required></p>
					<p class="col-md-6"><input type="text" name ="area" placeholder="Area"  value="<?php echo $area; ?>" required></p>
				</div>

          <p class="col-md-6 specialty-wrap"  >
						<select name ="gender" value="<?php echo $gender; ?>" >
							<option  selected disabled >Gender</option>
							<option name ="gender" id="option-1">Male</option>
                            <option name="gender" id="option-2">Female</option>

						</select>
            </p>

            <p class="col-md-6 language-wrap"> 
						
                    <input type="text" name = "phone_number"  value="<?php echo $phone_number; ?>" placeholder="Phone number" required>
						
					</p>
          
          
         
          
          <p class="col-xs-6"><input type="text" placeholder="specialty" name="specialty"  value="<?php echo $specialty; ?>" required></p>
          
          <p class="col-xs-6"><input type="text" placeholder="Years of experience" name ="years_of_exp" value="<?php echo $years_of_exp; ?>" required></p>
          
          <p class="col-xs-6">
          <select  name="allow_insurance"  id = "allow_insurance" value="<?php echo $allow_insurance;  ?>" required>
							<option value="0" selected disabled>Allow insurance</option>
							<option value="1">YES</option>
                            <option value="2">NO</option>

						</select>
            </p>
          
          <p class="col-xs-6">
          <select name = "allow_online_payment" id="allow_online_payment" value="<?php echo $allow_online_payment; ?>" required>
							<option value="" selected disabled>Allow online payment</option>
							<option value="1">YES</option>
                            <option value="2">NO</option>

						</select> 
            </p>
          
        </div>
        	<p class="register-toggle"></p>
			
            <?php if (isset($_SESSION['error'])) { ?>
                        <p class="error"><?php echo $_SESSION['error']; ?></p>
                        <?php
                            unset($_SESSION['error']);
                        } ?>

                <p class="register-submit"><input id="submit" type="submit" value="Register Now"></p>
			</form>
		</div>
	



		<!-- This is a placeholder fallback for IE9 browser -->
		<!-- For IE9 and below - placeholder fallback-->
		<!--[if lt IE 10]>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script src="jquery.placeholder.min.js"></script>
			<script type="text/javascript">
				$('input, textarea').placeholder();
			</script>
		<![endif]-->
	</body>
</html>
