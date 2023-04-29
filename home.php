<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['role'] != 'patient' || !isset($_SESSION['id'])) {
    header("Location: ../../login.php?error=unauthorized");
    exit();
}
$id = $_SESSION['id'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];
$phone_number = $_SESSION['phone_number'];
$role = $_SESSION['role'];  // should be 'patient'
$logged_in = $_SESSION['logged_in'];  // should be true
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $first_name; ?> | Home
    </title>
</head>

<body>
    <!-- logout form -->
    <form action="../shared/logout.php" method="post">
        <input type="submit" value="Logout">
    </form>
    <!-- display patient details -->
    <h1>Welcome <?php echo $first_name; ?></h1>
    <p>
        <strong>First Name:</strong>
        <?php echo $first_name; ?>
    </p>
    <p>
        <strong>Last Name:</strong>
        <?php echo $last_name; ?>
    </p>
    <p>
        <strong>Email:</strong>
        <?php echo $email; ?>
    </p>
    <p>
        <strong>Phone Number:</strong>
        <?php echo $phone_number; ?>
    </p>
    <p>
        <strong>Role:</strong>
        <?php echo $_SESSION['role']; ?>
    </p>
    <p>
        <strong>Id:</strong>
        <?php echo $id; ?>
    </p>
    <p>
        <strong>Logged In:</strong>
        <?php echo $_SESSION['logged_in']; ?>
    </p>
</body>

</html>