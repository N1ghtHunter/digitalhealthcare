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
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Doctor | Home</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="../lib/twentytwenty/twentytwenty.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/searchBar.css">

    <style>
        label {
            font-weight: bold;
            font-size: 1.2rem;
            color: white;
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

    <!-- Appointment Start -->
    <!-- Appointment Start -->
    <form action="../api/doctor/insertappointment.php" method="POST" id="appform">
        <div class="container-fluid bg-primary bg-appointment my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="row gx-5">
                    <div class="col-lg-12">
                        <div class="appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn" data-wow-delay="0.6s">
                            <h1 class="text-white mb-4">Make Appointment</h1>
                            <div>
                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <label for="name">Place</label>
                                        <select id="clinic_hospital" name="place" class="form-select bg-light border-0" style="height: 55px;">
                                            <option selected>Select clinic Or hospital </option>
                                            <?php
                                            include_once '../api/config/database.php';
                                            include_once '../api/objects/appointment.php';
                                            $clinic = new Appointment($db);
                                            $data = $clinic->selectClinicsHospitalByDoctorId($id);
                                            echo '<pre>';
                                            print_r($data);
                                            echo '</pre>';
                                            for ($i = 0; $i < count($data); $i++) { ?>
                                                <?php $test = implode(', ', $data[$i]); ?>
                                                <option value="<?php echo $test ?>">
                                                    <?php echo $test; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label for="fees">Fees</label>
                                        <input id="fees" name="cost" type="text" class="form-control bg-light border-0" placeholder="fees" style="height: 55px;">
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="date" id="date1" data-target-input="nearest">
                                            <label for="date">Appointment Date</label>
                                            <input id="date" name="date" type="date" class="form-control bg-light border-0 datetimepicker-input" placeholder="Appointment Date" style="height: 55px;">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="time" id="time1" data-target-input="nearest">
                                            <label for="start_time">Start Time</label>
                                            <input id="start_time" name="start_time" type="time" min="00:00" max="24:00" class="form-control bg-light border-0 datetimepicker-input" placeholder="Start Time" style="height: 55px;">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="time2" id="time2" data-target-input="nearest">
                                            <label for="end_time">End Time</label>
                                            <input id="end_time" name="end_time" type="time" min="00:00" max="24:00" class="form-control bg-light border-0 datetimepicker-input" placeholder="End Time" style="height: 55px;">
                                        </div>
                                    </div>
                                    <?php

                                    if (isset($_SESSION["add_appointment_success"]) && $_SESSION["add_appointment_success"] == true) { ?>
                                        <p class="success"><?php echo "appointment added successfully"; ?></p>
                                    <?php
                                        unset($_SESSION["add_appointment_success"]);
                                    } else if (isset($_SESSION["add_appointment_success"]) && $_SESSION["add_appointment_success"] == false) {
                                        echo "<p>failed</p>";
                                        unset($_SESSION["add_appointment_success"]);
                                    }
                                    ?>
                                    <div id="sumapp" class="col-12">
                                        <button class="btn btn-dark w-100 py-3" type="submit">Make Appointment</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Appointment End -->
    <div class="event-schedule-area-two bg-color pad100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <div class="title-text">
                            <h2>Event Schedule</h2>
                        </div>

                    </div>
                </div>
                <!-- /.col end-->
            </div>
            <!-- row end-->
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav custom-tab" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="home-taThursday" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Appointment</a>
                        </li>


                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="home" role="tabpanel">
                            <div class="table-responsive">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">Date</th>

                                            <th scope="col">Session</th>

                                            <th class="text-center" scope="col">Venue</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        include_once '../api/config/database.php';
                                        include_once '../api/objects/appointment.php';
                                        $db = $database->getConnection();

                                        $app = new Appointment($db);
                                        //TODO: Pass dr_id to the function
                                        $data = $app->SelsctAppointment($id);

                                        for ($i = 0; $i < count($data); $i++) { ?>
                                            <tr class="inner-box">
                                                <th scope="row">

                                                    <div class="event-date">
                                                        <span><?php echo date('d', strtotime($data[$i]['date'])); ?></span>
                                                        <p><?php echo date('F', strtotime($data[$i]['date'])); ?></p>
                                                    </div>
                                                </th>

                                                <td>
                                                    <div class="event-wrap">
                                                        <h3><a href="#"><?php echo $data[$i]['clinic_name'];
                                                                        echo $data[$i]['hospital_name']; ?></a></h3>
                                                        <div class="meta">
                                                            <?php echo "Address";
                                                            ?>
                                                            <div class="organizers">
                                                                <a href="#"><?php echo $data[$i]['clinic_address'];
                                                                            echo $data[$i]['hospital_address']; ?></a>
                                                            </div>
                                                            <?php echo "Cost";
                                                            ?>
                                                            <div class="organizers">
                                                                <a href="#"><?php echo $data[$i]['cost'];
                                                                            ?></a>
                                                            </div>
                                                            <div class="time">
                                                                <span><?php
                                                                        $hour = date('g', strtotime($data[$i]['start_time']));
                                                                        $minute = date('i', strtotime($data[$i]['start_time']));
                                                                        $amPm = date('A', strtotime($data[$i]['start_time']));
                                                                        echo $hour . ':' . $minute . ' ' . $amPm;
                                                                        echo "-";
                                                                        $hour = date('g', strtotime($data[$i]['end_time']));
                                                                        $minute = date('i', strtotime($data[$i]['end_time']));
                                                                        $amPm = date('A', strtotime($data[$i]['end_time']));
                                                                        echo $hour . ':' . $minute . ' ' . $amPm;
                                                                        // $interval = $data[$i]['start_time']->diff($data[$i]['end_time']);
                                                                        // echo $interval->format('%H:%I:%S');

                                                                        ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <form action="../api/doctor/deleteappointment.php" method="POST" id="appform">
                                                        <input name="delete_app" value="<?php echo $data[$i]['appointment_id'] ?>" type="text" placeholder=<?php echo $data[$i]['appointment_id'] ?> style="display:none">
                                                        <div class="primary-btn">
                                                            <button class="btn btn-primary" type="submit">Delete</button>
                                                        </div>
                                                        <?php

                                                        if (isset($_SESSION["delete_appointment_success"]) && $_SESSION["delete_appointment_success"] == true) { ?>
                                                            <p><?php echo "Appointment Deleded Successfully"; ?></p>
                                                        <?php
                                                            unset($_SESSION["delete_appointment_success"]);
                                                        } else if (isset($_SESSION["delete_appointment_success"]) && $_SESSION["delete_appointment_success"] == false) {
                                                            echo "<p>Failed</p>";
                                                            unset($_SESSION["delete_appointment_success"]);
                                                        }
                                                        ?>
                                                    </form>
                                                </td>
                                            </tr>




                                            </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>

                            </div>
                        </div>

                        <form action="../api/doctor/deleteallappointment.php" method="POST" id="appform">
                            <?php

                            if (isset($_SESSION["delete_all_appointment_success"]) && $_SESSION["delete_all_appointment_success"] == true) { ?>
                                <p><?php echo "Appointments Deleded Successfully"; ?></p>
                            <?php
                                unset($_SESSION["delete_all_appointment_success"]);
                            } else if (isset($_SESSION["delete_all_appointment_success"]) && $_SESSION["delete_all_appointment_success"] == false) {
                                echo "<p>Failed</p>";
                                unset($_SESSION["delete_all_appointment_success"]);
                            }
                            ?>
                            <div class="primary-btn text-center">
                                <button class="btn btn-primary" type="submit">Delete All</button>
                            </div>

                        </form>
                    </div>
                    <!-- /col end-->
                </div>
                <!-- /row end-->
            </div>
        </div>
        <!-- Appointment End -->


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light py-5 wow fadeInUp" data-wow-delay="0.3s" style="margin-top: -75px;">
            <div class="container pt-5">
                <div class="row g-5 pt-4">
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Quick Links</h3>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                            <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About
                                Us</a>
                            <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our
                                Services</a>
                            <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest
                                Blog</a>
                            <a class="text-light" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact
                                Us</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h3 class="text-white mb-4">Popular Links</h3>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                            <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About
                                Us</a>
                            <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our
                                Services</a>
                            <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest
                                Blog</a>
                            <a class="text-light" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact
                                Us</a>
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
                        <p class="mb-md-0">&copy; <a class="text-white border-bottom" href="#">Your Site Name</a>. All
                            Rights Reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <p class="mb-0">Designed by <a class="text-white border-bottom" href="https://htmlcodex.com">HTML
                                Codex</a></p>
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
        <!-- <script src="js/searchBAR.js"></script> -->
        <!-- <script>
    const myDiv = document.getElementById("sumsearch");
    const myForm = document.getElementById("searchform");
    // alert("SAdkfsfj")
    myDiv.addEventListener("click", function() {
        myForm.submit();
        // console.log(myDiv)
    });
    </script> -->
</body>

</html>