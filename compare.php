<?php
session_start();

include_once 'api/config/database.php';
include_once 'api/objects/appointment.php';

$database = Database::getInstance();
$db = $database->getConnection();
$appointment = new Appointment($db);

// if user is not logged in , set logged_in to false
$id;
$user;
$role;
$logged_in;
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['role'] != "patient" || !isset($_SESSION['patient'])) {
    $_SESSION['logged_in'] = false;
    header("Location: login.php");
} else if ($_SESSION['logged_in'] == true && $_SESSION['role'] == "patient") {
    $id = $_SESSION['id'];
    $user = $_SESSION['patient'];
    $role = $_SESSION['role'];
    $logged_in = $_SESSION['logged_in'];
}

$appIds = $_GET['compare'];
// print_r($appIds);
// convert the string to array of appIds ["1","2","3"]
$appIds = json_decode($appIds);
// print_r($appIds);
// get the appointments from the database

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Home</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Favicon -->
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

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/searchBar.css">
</head>

<body>
    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
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
            <div class="py-2 text-primary">
                <img src="image/logo1.png" alt="logo" style="width: 200px;">
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="home.php" class="nav-item nav-link active">Home</a>
                <a href="all-reservation.php" class="nav-item nav-link">Reservations</a>
                <!-- <a href="service.html" class="nav-item nav-link">Service</a> -->
                <!-- <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu m-0">
                        <a href="price.html" class="dropdown-item">Pricing Plan</a>
                        <a href="team.html" class="dropdown-item">Our Dentist</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="appointment.html" class="dropdown-item">Appointment</a>
                    </div>
                </div>
                <a href="contact.html" class="nav-item nav-link">Contact</a> -->
            </div>
            <!-- <a href="#searchform" class="btn text-dark"><i class="fa fa-search"></i></a> -->
            <!-- <a href="appointment.html" class="btn btn-primary py-2 px-4 ms-3">Appointment</a> -->
            <?php if (isset($_SESSION['patient'])) : ?>
                <a href="viewprofile.php" class="btn btn-primary py-2 px-4 ms-3">Profile</a>
                <form action="api/shared/logout.php" method="POST">
                    <button type="submit" class="btn btn-secondary py-2 px-4 ms-3">Logout</button>
                </form>
            <?php else : ?>
                <a href="login.php" class="btn btn-primary py-2 px-4 ms-3">Login</a>
            <?php endif; ?>


        </div>
    </nav>

    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container d-flex flex-wrap gap-3">
            <?php
            for ($i = 0; $i < count($appIds); $i++) {
                $result = $appointment->getFullByAppointmentId($appIds[$i]); ?>
                <div class="card rounded-4 border border-info" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize">
                            <?php echo "Dr. " . $result['doctor_name']; ?>
                        </h5>
                        <p class="card-text">
                            <?php
                            // check if it has a clinic or hospital
                            if ($result['clinic_name'] != null || $result['clinic_name'] != "") {
                                echo $result['clinic_name'] . "'s Clinic"
                                    . " - " . $result['clinic_address'];
                                echo "<br>";
                                echo "Phone: " . $result['clinic_phone'];
                            } else {
                                echo $result['hospital_name'] . " - " . $result['hospital_address'];
                                echo "<br>";
                                echo "Phone: " . $result['hospital_phone'];
                            }
                            echo "<br>";
                            // state and area
                            echo $result['state'] . ", " . $result['area'];
                            ?>
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-bottom border-info">
                            <?php
                            // specialty
                            echo $result['specialty'];
                            ?>
                        </li>
                        <li class="list-group-item border-bottom border-info ">
                            <?php
                            // Years of experience
                            echo $result['years_of_exp'] . " years of experience";
                            ?>
                        </li>
                        <li class="list-group-item border-bottom border-info">
                            <?php
                            // date and time
                            // change the date format from yyyy-mm-dd to include the day name and month name and day number and year
                            $date = date_create($result['date']);
                            $date = date_format($date, "l, F j, Y");
                            // echo $date;
                            echo $date . " at " . $result['start_time'] . " - " . $result['end_time'];
                            ?>
                        </li>
                        <li class="list-group-item">
                            <?php
                            // price
                            echo "Price: " . $result['cost'] . " EGP";
                            echo "<br>";
                            // insurance
                            echo "Insurance: ";
                            echo $result['allow_insurance'] ? "Yes" : "No";
                            echo "<br>";
                            // payment method
                            echo "Online Payment: ";
                            echo $result['allow_online_payment'] ? "Yes" : "No";
                            ?>
                        </li>
                    </ul>
                    <div class="card-body">
                        <a href="<?php
                                    // start_time	end_time	doctor_id	patient_id	clinic_id	hospital_id date cost allow_insurance allow_online_payment
                                    $url = "book.php?start_time=" . $result['start_time'] . "&end_time=" . $result['end_time'] . "&doctor_id=" . $result['id'] . "&patient_id=" . $_SESSION['id'];
                                    if ($result['clinic_id'] != null || $result['clinic_id'] != "")
                                        $url .= "&clinic_id=" . $result['clinic_id'];
                                    else
                                        $url .= "&hospital_id=" . $result['hospital_id'];
                                    $url .= "&date=" . $result['date'] . "&cost=" . $result['cost'];
                                    if ($result['allow_insurance']) {
                                        $url .= "&allow_insurance=true";
                                    } else {
                                        $url .= "&allow_insurance=false";
                                    }
                                    if ($result['allow_online_payment']) {
                                        $url .= "&allow_online_payment=true";
                                    } else {
                                        $url .= "&allow_online_payment=false";
                                    }
                                    echo $url;
                                    ?>" target="_blank" class="card-link btn btn-primary">Book</a>
                    </div>
                </div>
            <?php }

            ?>
        </div>
    </div>



    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="lib/twentytwenty/jquery.event.move.js"></script>
    <script src="lib/twentytwenty/jquery.twentytwenty.js"></script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <!-- <script src="js/searchBAR.js"></script> -->
    <script>
        const myDiv = document.getElementById("sumsearch");
        const myForm = document.getElementById("searchform");
        // alert("SAdkfsfj")
        myDiv.addEventListener("click", function() {
            myForm.submit();
            // console.log(myDiv)
        });
    </script>
</body>

</html>