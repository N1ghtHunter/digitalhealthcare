<!-- // Purpose: This file will display the search results -->
<?php
session_start();

$id;
$user;
$role;
$logged_in;
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['role'] != "patient" || !isset($_SESSION['patient'])) {
    $_SESSION['logged_in'] = false;
    header("Location: http://localhost/login.php");
} else if ($_SESSION['logged_in'] == true && $_SESSION['role'] == "patient") {
    $id = $_SESSION['id'];
    $user = $_SESSION['patient'];
    $role = $_SESSION['role'];
    $logged_in = $_SESSION['logged_in'];
}
if (!isset($_SESSION['searchResults'])) {
    header("Location: home.php");
    exit();
}
$searchResults = $_SESSION['searchResults'];

// this is a search result page
// it will display the search results
// it will also display the filters
// it will also display the sort options
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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

    <link rel="stylesheet" href="css/cards.css">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
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
    <!-- search result -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container d-flex flex-wrap gap-3">
            <!-- use bootstrap cards to display results -->
            <?php if (count($searchResults) == 0) : ?>
                <h1 class="text-center">No results found</h1>
            <?php endif;
            // display the results in cards

            foreach ($searchResults as $result) : ?>

                <div class="card rounded-4 border border-info" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize">
                            <?php echo "Dr. " . $result['first_name'] . " " . $result['last_name']; ?>
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
                        <!-- <a href="#" class="card-link">Another link</a> -->
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
    <!-- Back to Top -->
    <a href=" #" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>
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
</body>

</html>