<?php
session_start();


$first_name = '';
$last_name = '';
$email = '';
$phone_number = '';
$gender = '';
$specialty = '';
$state = '';
$area = '';
$years_of_exp = '';
$allow_online_payment;
$allow_insurance;

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
    <meta name="viewport" content="width=device-width, initial-scale=1.2">
    <link rel="stylesheet" href="../icons/styles.css">
    <!-- <link rel="stylesheet" href="style2.css"> -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,600' rel='stylesheet' type='text/css'>

    <style>
        body {
            background: radial-gradient(#06A3DA, #091E3E);
        }

        .form-wrapper {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .register-info {
            text-align: center;
            margin-bottom: 20px;
            background-color: #091E3E;
            color: #EEF9FF;
            padding: 10px;
            border-radius: 5px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        .register-submit {
            text-align: center;
            margin-bottom: 20px;
        }

        #submit {
            background-color: #091E3E;
            color: #EEF9FF;
            padding: 10px;
            transition: 0.3s;
            border: none;
        }

        #submit:hover {
            background-color: #F57E57;
            border: none;

        }
    </style>

</head>

<body>
    <!-- Register Form -->
    <div class="container">
        <div class="form-wrapper">
            <form action="../api/doctor/signup.php" method="post" class="fcorn-register container">
                <h2 class="register-info">Welcome to the doctor SIGN UP page</h2>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" id="first_name" value="<?php echo $first_name; ?>" required>
                        <?php if (isset($_SESSION['name_error'])) { ?>
                            <p class="error"><?php echo $_SESSION['name_error']; ?></p>
                            <?php unset($_SESSION['name_error']); ?>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="last_name" value="<?php echo $last_name; ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?php echo $email; ?>" required>
                    <?php if (isset($_SESSION['email_error'])) { ?>
                        <p class="error"><?php echo $_SESSION['email_error']; ?></p>
                        <?php unset($_SESSION['email_error']); ?>
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                    <?php if (isset($_SESSION['password_error'])) { ?>
                        <p class="error"><?php echo $_SESSION['password_error']; ?></p>
                        <?php unset($_SESSION['password_error']); ?>
                    <?php } ?>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="state" class="form-label">City</label>
                        <!-- <input type="text" name="state" class="form-control" id="state" value" required> -->
                        <select name="state" class="form-select" id="state">
                            <option value="" selected disabled>Select a governorate</option>
                            <option value="Alexandria">Alexandria</option>
                            <option value="Aswan">Aswan</option>
                            <option value="Asyut">Asyut</option>
                            <option value="Beheira">Beheira</option>
                            <option value="Beni Suef">Beni Suef</option>
                            <option value="Cairo">Cairo</option>
                            <option value="Dakahlia">Dakahlia</option>
                            <option value="Damietta">Damietta</option>
                            <option value="Faiyum">Faiyum</option>
                            <option value="Gharbia">Gharbia</option>
                            <option value="Giza">Giza</option>
                            <option value="Ismailia">Ismailia</option>
                            <option value="Kafr El Sheikh">Kafr El Sheikh</option>
                            <option value="Luxor">Luxor</option>
                            <option value="Matrouh">Matrouh</option>
                            <option value="Minya">Minya</option>
                            <option value="Monufia">Monufia</option>
                            <option value="New Valley">New Valley</option>
                            <option value="North Sinai">North Sinai</option>
                            <option value="Port Said">Port Said</option>
                            <option value="Qalyubia">Qalyubia</option>
                            <option value="Qena">Qena</option>
                            <option value="Red Sea">Red Sea</option>
                            <option value="Sharqia">Sharqia</option>
                            <option value="Sohag">Sohag</option>
                            <option value="South Sinai">South Sinai</option>
                            <option value="Suez">Suez</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="area" class="form-label">Area</label>
                        <input type="text" name="area" class="form-control" id="area" value="<?php echo $area; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" class="form-select" id="gender">
                            <option selected disabled>Choose...</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone_number" class="form-label">Phone number</label>
                        <input type="text" name="phone_number" class="form-control" id="phone_number" value="<?php echo $phone_number; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <label for="specialty-select" class="form-label">Select a Medical Specialty:</label>
                        <select id="specialty-select" class="form-select" name="specialty">
                            <option value="" disabled selected>--Select One--</option>
                            <option value="allergy">Allergy and Immunology</option>
                            <option value="anesthesiology">Anesthesiology</option>
                            <option value="cardiology">Cardiology</option>
                            <option value="dermatology">Dermatology</option>
                            <option value="emergency">Emergency Medicine</option>
                            <option value="endocrinology">Endocrinology</option>
                            <option value="gastroenterology">Gastroenterology</option>
                            <option value="hematology">Hematology</option>
                            <option value="infectious">Infectious Disease</option>
                            <option value="internal">Internal Medicine</option>
                            <option value="neonatology">Neonatology</option>
                            <option value="nephrology">Nephrology</option>
                            <option value="neurology">Neurology</option>
                            <option value="obstetrics">Obstetrics and Gynecology</option>
                            <option value="oncology">Oncology</option>
                            <option value="ophthalmology">Ophthalmology</option>
                            <option value="orthopedic">Orthopedic Surgery</option>
                            <option value="otolaryngology">Otolaryngology</option>
                            <option value="pediatric">Pediatrics</option>
                            <option value="physical">Physical Medicine and Rehabilitation</option>
                            <option value="psychiatry">Psychiatry</option>
                            <option value="pulmonology">Pulmonology</option>
                            <option value="radiology">Radiology</option>
                            <option value="rheumatology">Rheumatology</option>
                            <option value="urology">Urology</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="years_of_experience" class="form-label">Years of experience</label>
                        <input type="number" name="years_of_exp" class="form-control" id="years_of_experience" value="<?php echo $years_of_experience; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <!-- allow insurance yes or no and allow online payment  -->
                    <div class="col-md-6 mb-3">
                        <label for="insurance" class="form-label">Do you accept insurance?</label>
                        <select name="allow_insurance" class="form-select" id="insurance">
                            <option value="0" selected disabled>Choose...</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="online_payment" class="form-label">Do you accept online payment?</label>
                        <select name="allow_online_payment" class="form-select" id="online_payment">
                            <option value="0" selected disabled>Choose...</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <?php if (isset($_SESSION['error'])) { ?>
                    <p class="error"><?php echo $_SESSION['error']; ?></p>
                <?php
                    unset($_SESSION['error']);
                } ?>
                <div class="register-submit">
                    <input id="submit" type="submit" value="Register Now">
                </div>
            </form>
        </div>
    </div>


</body>

</html>