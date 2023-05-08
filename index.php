<?php
session_start();


$firstname = '';
$lastname = '';
$email = '';
$phone_number = '';
$gender = '';
$age = '';
$insurance_info = '';
$blood_type = '';
$date_of_birth = '';

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

if (isset($_SESSION['age'])) {
    $age = $_SESSION['age'];
}
if (isset($_SESSION['insurance_info'])) {
    $insurance_info = $_SESSION['insurance_info'];
}
if (isset($_SESSION['blood_type'])) {
    $blood_type = $_SESSION['blood_type'];
}
if (isset($_SESSION['date_of_birth'])) {
    $date_of_birth = $_SESSION['date_of_birth'];
}
?>
<!-- create a singup form with required attributes -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .error {
        color: red;
        border: 1px solid red;
        padding: 5px;
        margin-bottom: 10px;
        background-color: #ffcccb;
        border-radius: 5px;
    }
    </style>
    <link rel="stylesheet" href="css/signup.css">
</head>

<body>
    <section class="login">
        <div class="login_box">
            <div class="left">
                <div class="top_link"><a href="/home.php"><img
                            src="https://drive.google.com/u/0/uc?id=16U__U5dJdaTfNGobB_OpwAJ73vM50rPV&export=download"
                            alt="">Return home</a></div>
                <div class="contact">
                    <form action="api/patient/create.php" method="POST">
                        <h3>SIGN UP</h3>
                        <input type="text" name="first_name" placeholder="First Name *"
                            value="<?php echo $firstname; ?>" required>
                        <input type="text" name="last_name" placeholder="Last Name *" value="<?php echo $lastname; ?>"
                            required>
                        <?php if (isset($_SESSION['name_error'])) { ?>
                        <p class="error"><?php echo $_SESSION['name_error']; ?></p>
                        <?php
                            unset($_SESSION['name_error']);
                        } ?>
                        <input type="email" name="email" placeholder="Email *" value="<?php echo $email; ?>" required>
                        <?php if (isset($_SESSION['email_error'])) { ?>
                        <p class="error"><?php echo $_SESSION['email_error']; ?></p>
                        <?php
                            unset($_SESSION['email_error']);
                        } ?>
                        <input type="text" name="phone_number" placeholder="Phone *"
                            value="<?php echo $phone_number; ?>" required>
                        <p>Gender: *</p>
                        <div class="wrapper">
                            <input type="radio" name="gender" value="male" id="option-1" checked>
                            <input type="radio" name="gender" value="female" id="option-2">
                            <label for="option-1" class="option option-1">
                                <div class="dot"></div>
                                <span>Male</span>
                            </label>
                            <label for="option-2" class="option option-2">
                                <div class="dot"></div>
                                <span>Female</span>
                            </label>
                        </div>
                        <!-- date -->
                        <label for="birthday" style="margin-bottom: 0; margin-top:8px;">Date of birth *</label>
                        <input type="date" id="birthday" name="date_of_birth" value="<?php echo $date_of_birth; ?>"
                            required>
                        <input type="password" name="password" placeholder="Password" required>
                        <?php if (isset($_SESSION['password_error'])) { ?>
                        <p class="error"><?php echo $_SESSION['password_error']; ?></p>
                        <?php
                            unset($_SESSION['password_error']);
                        } ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="blood_type" style="margin-bottom: 0; margin-top:0px;">Blood
                                Type:</label>
                            <select name="blood_type" id="blood_type" class="blood_type px-2"
                                value="<?php echo $blood_type; ?>">
                                <option value="" selected disabled hidden>Select Blood Type</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                        <input type="text" name="insurance_info" placeholder="Insurance Info"
                            value="<?php echo $insurance_info; ?>">
                        <input type="text" name="age" placeholder="Age *" value="<?php echo $age; ?>" required>

                        <?php if (isset($_SESSION['error'])) { ?>
                        <p class="error"><?php echo $_SESSION['error']; ?></p>
                        <?php
                            unset($_SESSION['error']);
                        } ?>
                        <input id="submit" type="submit" value="Sign Up">
                        <p class="pt-3">Already have an account? <a href="login.php">Login</a></p>
                    </form>
                </div>
            </div>
            <div class="right">
                <div class="right-text">
                    <h2>Ek4fly</h2>
                    <h5>A DIGITAL HEALTH CARE APPLICATION</h5>
                    <p>
                        &#169; 2023 Vezzeta. All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    </section>
</body>

</html>