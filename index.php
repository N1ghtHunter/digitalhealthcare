<?php
session_start();


$firstname = '';
$lastname = '';
$email = '';
$phone_number = '';
$gender = '';
$age = '';

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

// set ID of patient to fetch
$id = 1;

// set URL of read_single.php endpoint
$url = 'http://localhost/api/patient/read_single.php';

// create data to send in the request body
$data = array('id' => $id);

// // create cURL handle
// $ch = curl_init();

// // set cURL options
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

// send the request and get the response
// $response = curl_exec($ch);

// // check for errors
// if (curl_errno($ch)) {
//     echo 'cURL error: ' . curl_error($ch);
// } else {
//     // decode JSON response
//     $patient = json_decode($response);

//     // check if patient was found
//     if ($patient) {
//         // display patient details
//         echo "<pre>";
//         print_r($patient->first_name);
//         echo "</pre>";
//         // ...
//     } else {
//         echo 'Patient not found.';
//     }
// }

// // close cURL handle
// curl_close($ch);
?>
<!-- create a singup form with required attributes -->
<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

.error {
    color: red;
}
</style>
<form action="api/patient/create.php" method="POST" style="border:1px solid #ccc; display: flex; flex-direction: column; width: 50%; margin: 0 auto; padding: 20px;
    gap:5px;">
    <input type="text" name="first_name" placeholder="First Name" value="<?php echo $firstname; ?>" required>
    <input type="text" name="last_name" placeholder="Last Name" value="<?php echo $lastname;?>" required>
    <?php if (isset($_SESSION['name_error'])) { ?>
    <p class="error"><?php echo $_SESSION['name_error']; ?></p>
    <?php
        unset($_SESSION['name_error']);
    } ?>
    <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
    <?php if (isset($_SESSION['email_error'])) { ?>
    <p class="error"><?php echo $_SESSION['email_error']; ?></p>
    <?php
        unset($_SESSION['email_error']);
    } ?>
    <input type="text" name="phone_number" placeholder="Phone" value="<?php echo $phone_number; ?>" required>
    <!-- gender radio -->
    <div style="width: 50%; margin: 0 auto; padding: 10px;">
        <input type="radio" name="gender" value="male"> Male
        <input type="radio" name="gender" value="female"> Female
    </div>
    <!-- date -->
    <label for="birthday">Date of birth:</label>
    <input type="date" id="birthday" name="date_of_birth">
    <input type="password" name="password" placeholder="Password" required>
    <?php if (isset($_SESSION['password_error'])) { ?>
    <p class="error"><?php echo $_SESSION['password_error']; ?></p>
    <?php
        unset($_SESSION['password_error']);
    } ?>
    <label for="blood_type">Blod Type:</label>
    <select name="blood_type" id="blood_type">
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
    </select>
    <input type="text" name="insurance_info" placeholder="Insurance Info">
    <input type="text" name="age" placeholder="Age">
    <?php if (isset($_SESSION['error'])) { ?>
    <p class="error"><?php echo $_SESSION['error']; ?></p>
    <?php
        unset($_SESSION['error']);
    } ?>
    <input type="submit" value="Sign Up">
</form>
<!-- create a login form with required attributes -->