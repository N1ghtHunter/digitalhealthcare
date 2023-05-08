<?php session_start();

?>

<!DOCTYPE html>

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
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="lib/twentytwenty/twentytwenty.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/searchBar.css">
</head>

<body>


    <!-- Appointment Start -->
    <form action="../api/doctor/insertappointment.php" method="POST" id="appform">
        <div class="container-fluid bg-primary bg-appointment my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container">
                <div class="row gx-5">
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
                                            $data = $clinic->selectClinicsHospitalByDoctorId(1);
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
                                            <input name="date" type="date" class="form-control bg-light border-0 datetimepicker-input" placeholder="Appointment Date" data-target="#date1" data-toggle="datetimepicker" style="height: 55px;">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="time" id="time1" data-target-input="nearest">
                                            <input name="start_time" type="time" min="00:00" max="24:00" class="form-control bg-light border-0 datetimepicker-input" placeholder="Start Time" data-target="#time1" data-toggle="datetimepicker" style="height: 55px;">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="time2" id="time2" data-target-input="nearest">
                                            <input name="end_time" type="time" min="00:00" max="24:00" class="form-control bg-light border-0 datetimepicker-input" placeholder="End Time" data-target="#time2" data-toggle="datetimepicker" style="height: 55px;">
                                        </div>
                                    </div>
                                    <?php

                                    if (isset($_SESSION["add_appointment_success"]) && $_SESSION["add_appointment_success"] == true) { ?>
                                        <p><?php echo "appointment added successfully"; ?></p>
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
                            </form>
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
                                        $data = $app->SelsctAppointment(1);

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
        <!-- <script src="js/searchBAR.js"></script> -->
</body>

</html>