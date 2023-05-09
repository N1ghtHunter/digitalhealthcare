<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "digitalhealthcare");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the ID of the record to delete from the URL parameter
$id = $_POST["id"];

// Delete the record from the table
$sql = "DELETE FROM clinic WHERE id = $id";
if (mysqli_query($conn, $sql)) {
    header("Location: ../../doctor/clinic.php");
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>