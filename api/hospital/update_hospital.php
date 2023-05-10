<?php
session_start();
// Connect to the database
include_once '../config/database.php';
include_once '../objects/hospital.php';
$database = Database::getInstance();
$db = $database->getConnection();

$hospital = new Hospital($db);
// Get the ID of the record to update from the URL parameter
$id = $_POST["id"];
$row = $hospital->getHospital($id);
$doctor_id = $row["doctor_id"];
// Update the record in the table
if (isset($_POST["name"]) && isset($_POST["address"]) && isset($_POST["phone_number"])) {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];
    $id = $row["id"];

    // Check for empty values
    if (empty($name) || empty($address) || empty($phone_number)) {
        $error_msg = "Error: Please fill in all fields.";
    } else {
        $res = $hospital->updateHospital($id, $name, $address, $phone_number);
        if ($res != -1) {
            header("Location: ../../doctor/hospital.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit hospital</title>
</head>

<body>

    <form method="POST" action="">
        <?php if (isset($error_msg)) { ?>
            <p style="color: red"><?php echo $error_msg; ?></p>
        <?php } ?>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $row["name"]; ?>">
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="<?php echo $row["address"]; ?>">
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" id="phone_number" pattern="[0-9]*" value="<?php echo $row["phone_number"]; ?>">
        <input type="hidden" name="doctor_id" value="1">
        <button type="submit">Update hospital</button>
        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
    </form>

</body>

</html>