<?php
session_start();
include_once "../api/config/database.php";
include_once "../api/objects/doctor.php";


$database = Database::getInstance();
$db = $database->getConnection();
$id;
$user;
$role;
$logged_in;
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['role'] != "doctor") {
    header("Location: http://localhost/doctor/login.php");
    exit();
} else if ($_SESSION['logged_in'] == true && $_SESSION['role'] == "doctor") {
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
    $id = $_SESSION['id'];
    $user = $_SESSION['doctor'];
    $role = $_SESSION['role'];
    $logged_in = $_SESSION['logged_in'];
}


?>


<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hospital</title>

    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="lib/twentytwenty/twentytwenty.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/clinicPage.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">


    <link href="../css/style.css" rel="stylesheet">


    <title>Doctors' hospital</title>

    <style>
        label {
            font-weight: bold;
            font-size: 1.2rem;
            /* color: white; */
            text-align: left;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
        <a href="index.html" class="navbar-brand p-0">
            <div class="py-2 text-primary">
                <img src="../image/logo1.png" alt="logo" style="width: 200px;">
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="home.php" class="nav-item nav-link active">Home</a>
                <a href="clinic.php" class="nav-item nav-link">Clinics</a>
                <a href="hospital.php" class="nav-item nav-link">Hospital</a>

                <a href="home.php#appform" class="nav-item nav-link">Appointment</a>
            </div>
            <a href="#searchform" class="btn text-dark"><i class="fa fa-search"></i></a>
            <!-- <a href="appointment.html" class="btn btn-primary py-2 px-4 ms-3">Appointment</a> -->
            <?php if (isset($_SESSION['doctor'])) : ?>
                <a href="viewprofile.php" class="btn btn-primary py-2 px-4 ms-3">Profile</a>
                <form action="../api/shared/drLogout.php" method="POST">
                    <button type="submit" class="btn btn-secondary py-2 px-4 ms-3">Logout</button>
                </form>
            <?php else : ?>
                <a href="login.php" class="btn btn-primary py-2 px-4 ms-3">Login</a>
            <?php endif; ?>


        </div>
    </nav>
    <!-- Navbar End -->

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th style="display: none;">Doctor ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Connect to the database
            $conn = mysqli_connect("localhost", "root", "", "digitalhealthcare");
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            // Insert data into the table
            if (isset($_POST["name"]) && isset($_POST["address"]) && isset($_POST["phone_number"]) && isset($_POST["doctor_id"])) {
                $name = $_POST["name"];
                $address = $_POST["address"];
                $phone_number = $_POST["phone_number"];
                $doctor_id = $_POST["doctor_id"];
                $sql = "INSERT INTO hospital (name, address, phone_number, doctor_id) VALUES ('$name', '$address', '$phone_number', '$doctor_id')";
                if (mysqli_query($conn, $sql)) {
                } else {
                    echo "<tr><td colspan='5'>Error adding contact: " . mysqli_error($conn) . "</td></tr>";
                }
            }
            // Select data from the table
            $sql = "SELECT id, name, address, phone_number, doctor_id FROM hospital where doctor_id = " . $_SESSION['doctor']['id'] . "";
            $result = mysqli_query($conn, $sql);
            // Loop through the data and output it in the table
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["name"] . "</td><td>" . $row["address"] . "</td><td>" . $row["phone_number"] . "</td><td style='display: none;'>" . $row["doctor_id"] . "</td><td><form method='POST' action='../api/hospital/update_hospital.php'><input type='hidden' name='id' value='" . $row["id"] . "'><button type='submit'>Edit</button></form><form method='POST' action='../api/hospital/delete_hospital.php'><input type='hidden' name='id' value='" . $row["id"] . "'><button type='submit'>Delete</button></form></td></tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No results found</td></tr>";
            }
            // Close the database connection
            mysqli_close($conn);
            ?>

        </tbody>
    </table>

    <div class="container d-flex justify-content-center align-items-center flex-column" style="margin: 0 auto; width:700px;">
        <h1>Add Hospital</h1>
        <form method="POST" action="../api/hospital/add_hospital.php" style="display: flex; flex-direction: column; width: 100%; max-width: 500px; margin: 0 auto;">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" required>
            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" required>
            <input type="hidden" name="doctor_id" value=>
            <button type="submit">Add hospital</button>
        </form>
    </div>

    <script>
        // Get the phone_number input element
        const phoneInput = document.getElementById("phone_number");

        // Add an event listener to the input element
        phoneInput.addEventListener("input", function(event) {
            // Check if the input contains non-numeric characters
            if (!(/^\d+$/.test(event.target.value))) {
                // Display a pop-up message
                alert("Please enter only numbers in the Phone Number field.");
                // Clear the input field
                event.target.value = "";
            }
        });
    </script>
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light py-5 wow fadeInUp" data-wow-delay="0.3s" style="margin-top: 20px;">
        <div class="container pt-5">
            <div class="row g-5 pt-4">
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Quick Links</h3>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                        <a class="text-light" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Popular Links</h3>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                        <a class="text-light" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Get In Touch</h3>
                    <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="bi bi-envelope-open text-primary me-2"></i>info@example.com</p>
                    <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i>+012 345 67890</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Follow Us</h3>
                    <div class="d-flex">
                        <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="#"><i class="fab fa-twitter fw-normal"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="#"><i class="fab fa-facebook-f fw-normal"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="#"><i class="fab fa-linkedin-in fw-normal"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded" href="#"><i class="fab fa-instagram fw-normal"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid text-light py-4" style="background: #051225;">
        <div class="container">
            <div class="row g-0">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-md-0">&copy; <a class="text-white border-bottom" href="#">Your Site Name</a>. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Designed by <a class="text-white border-bottom" href="https://htmlcodex.com">HTML Codex</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="../lib/twentytwenty/jquery.event.move.js"></script>
    <script src="../lib/twentytwenty/jquery.twentytwenty.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

</body>

</html>