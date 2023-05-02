<?php
session_start();
$id;
$user;
$role;
$logged_in;
if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
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
    <title>DentCare - Dental Clinic Website Template</title>
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
</head>

<body>
    <!-- Spinner Start -->
    <!-- <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-dark m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> -->
    <!-- Spinner End -->
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
        <a href="index.html" class="navbar-brand p-0">
            <h1 class="m-0 text-primary"><i class="fa fa-tooth me-2"></i>DentCare</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.html" class="nav-item nav-link active">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="service.html" class="nav-item nav-link">Service</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu m-0">
                        <a href="price.html" class="dropdown-item">Pricing Plan</a>
                        <a href="team.html" class="dropdown-item">Our Dentist</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="appointment.html" class="dropdown-item">Appointment</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>
            <a href="#searchform" class="btn text-dark"><i class="fa fa-search"></i></a>
            <!-- <a href="appointment.html" class="btn btn-primary py-2 px-4 ms-3">Appointment</a> -->
            <?php if (isset($_SESSION['doctor'])) : ?>
                <a href="profile.php" class="btn btn-primary py-2 px-4 ms-3">Profile</a>
                <form action="../api/shared/logout.php" method="POST">
                    <button type="submit" class="btn btn-secondary py-2 px-4 ms-3">Logout</button>
                </form>
            <?php else : ?>
                <a href="login.php" class="btn btn-primary py-2 px-4 ms-3">Login</a>
            <?php endif; ?>


        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Appointment Start -->
    <form action="../api/doctor/insertappointment.php" method="POST" id="appform">
        <div class="container-fluid bg-primary bg-appointment my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="row gx-5">
                    <!-- <div class="col-lg-6 py-5">
                        <div class="py-5">
                            <h1 class="display-5 text-white mb-4">We Are A Certified and Award Winning Dental Clinic You
                                Can Trust</h1>
                            <p class="text-white mb-0">Eirmod sed tempor lorem ut dolores. Aliquyam sit sadipscing kasd
                                ipsum. Dolor ea et dolore et at sea ea at dolor, justo ipsum duo rebum sea invidunt
                                voluptua. Eos vero eos vero ea et dolore eirmod et. Dolores diam duo invidunt lorem.
                                Elitr ut dolores magna sit. Sea dolore sanctus sed et. Takimata takimata sanctus sed.
                            </p>
                        </div>
                    </div> -->
                    <div class="col-lg-12">
                        <div class="appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn" data-wow-delay="0.6s">
                            <h1 class="text-white mb-4">Make Appointment</h1>
                            <form>
                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <select name="place" class="form-select bg-light border-0" style="height: 55px;">
                                            <option selected>Select clinic Or hospital </option>
                                            <?php
                                            include_once '../api/config/database.php';
                                            include_once '../api/objects/appointment.php';
                                            $db = $database->getConnection();
                                            $clinic = new Appointment($db);
                                            $data = $clinic->selectClinicsByDoctorId($_SESSION['id']);
                                            for ($i = 0; $i < count($data); $i++) { ?>
                                                <?php $test = implode(', ', $data[$i]); ?>
                                                <option value="<?php echo $test ?>">
                                                    <?php echo $test; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <input name="cost" type="text" class="form-control bg-light border-0" placeholder="Cost" style="height: 55px;">
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="date" id="date1" data-target-input="nearest">
                                            <input name="date" type="date" class="form-control bg-light border-0" placeholder="Appointment Date" style="height: 55px;">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="time" id="time1" data-target-input="nearest">
                                            <input name="start_time" type="time" min="00:00" max="24:00" class="form-control bg-light border-0" placeholder="Start Time" style="height: 55px;">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="time2" id="time2" data-target-input="nearest">
                                            <input name="end_time" type="time" min="00:00" max="24:00" class="form-control bg-light border-0 " placeholder="End Time" style="height: 55px;">
                                        </div>
                                    </div>
                                    <?php

                                    if (isset($_SESSION["add_appointment_success"]) && $_SESSION["add_appointment_success"] == true) { ?>
                                        <p style="color: white;"><?php echo "appointment added successfully"; ?></p>
                                    <?php
                                        unset($_SESSION["add_appointment_success"]);
                                    } else if (isset($_SESSION["add_appointment_success"]) && $_SESSION["add_appointment_success"] == false) {
                                        echo "<p 
                                        class='text-danger'
                                        >failed</p>";
                                        unset($_SESSION["add_appointment_success"]);
                                    }
                                    ?>
                                    <div id="sumapp" class="col-12">
                                        <button class="btn btn-dark w-100 py-3" type="submit">Make Appointment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Appointment End -->

    <!-- About Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title mb-4">
                        <h5 class="position-relative d-inline-block text-primary text-uppercase">About Us</h5>
                        <h1 class="display-5 mb-0">The World's Best Dental Clinic That You Can Trust</h1>
                    </div>
                    <h4 class="text-body fst-italic mb-4">Diam dolor diam ipsum sit. Clita erat ipsum et lorem stet no
                        lorem sit clita duo justo magna dolore</h4>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor sit. Aliqu diam
                        amet diam et eos labore. Clita erat ipsum et lorem et sit, sed stet no labore lorem sit. Sanctus
                        clita duo justo et tempor eirmod magna dolore erat amet</p>
                    <div class="row g-3">
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.3s">
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Award Winning</h5>
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Professional Staff</h5>
                        </div>
                        <div class="col-sm-6 wow zoomIn" data-wow-delay="0.6s">
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>24/7 Opened</h5>
                            <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Fair Prices</h5>
                        </div>
                    </div>
                    <a href="appointment.html" class="btn btn-primary py-3 px-5 mt-4 wow zoomIn" data-wow-delay="0.6s">Make Appointment</a>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s" src="../img/about.jpg" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


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