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
                    <div class="col-lg-6 py-5">
                        <div class="py-5">
                            <h1 class="display-5 text-white mb-4">We Are A Certified and Award Winning Dental Clinic You
                                Can Trust</h1>
                            <p class="text-white mb-0">Eirmod sed tempor lorem ut dolores. Aliquyam sit sadipscing kasd
                                ipsum. Dolor ea et dolore et at sea ea at dolor, justo ipsum duo rebum sea invidunt
                                voluptua. Eos vero eos vero ea et dolore eirmod et. Dolores diam duo invidunt lorem.
                                Elitr ut dolores magna sit. Sea dolore sanctus sed et. Takimata takimata sanctus sed.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
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
                                            $data = $clinic->selectClinicsByDoctorId(1);
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
                                        <tr class="inner-box">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>16</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>

                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Harman Kardon</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="inner-box">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>20</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Toni Duggan</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="inner-box border-bottom-0">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>18</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Billal Hossain</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="r-no">
                                                    <span>Room A3</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Speakers</th>
                                            <th scope="col">Session</th>
                                            <th scope="col">Venue</th>
                                            <th scope="col">Venue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="inner-box">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>16</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Harman Kardon</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="r-no">
                                                    <span>Room B3</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="inner-box">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>16</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Billal Hossain</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="r-no">
                                                    <span>Room B3</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="inner-box border-bottom-0">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>16</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Toni Duggan</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="r-no">
                                                    <span>Room B3</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="sunday" role="tabpanel" aria-labelledby="sunday-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Speakers</th>
                                            <th scope="col">Session</th>
                                            <th scope="col">Venue</th>
                                            <th scope="col">Venue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="inner-box">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>16</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Toni Duggan</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="r-no">
                                                    <span>Room B3</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="inner-box">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>16</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Harman Kardon</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="r-no">
                                                    <span>Room B3</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="inner-box border-bottom-0">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>16</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Billal Hossain</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="r-no">
                                                    <span>Room B3</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="monday" role="tabpanel" aria-labelledby="monday-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Speakers</th>
                                            <th scope="col">Session</th>
                                            <th scope="col">Venue</th>
                                            <th scope="col">Venue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="inner-box">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>16</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Harman Kardon</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="r-no">
                                                    <span>Room B3</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="inner-box">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>18</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Toni Duggan</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="r-no">
                                                    <span>Room B3</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="inner-box border-bottom-0">
                                            <th scope="row">
                                                <div class="event-date">
                                                    <span>20</span>
                                                    <p>Novembar</p>
                                                </div>
                                            </th>
                                            <td>
                                                <div class="event-img">
                                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="event-wrap">
                                                    <h3><a href="#">Billal Hossain</a></h3>
                                                    <div class="meta">
                                                        <div class="organizers">
                                                            <a href="#">Aslan Lingker</a>
                                                        </div>
                                                        <div class="categories">
                                                            <a href="#">Inspire</a>
                                                        </div>
                                                        <div class="time">
                                                            <span>05:35 AM - 08:00 AM 2h 25'</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="r-no">
                                                    <span>Room B3</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="primary-btn">
                                                    <a class="btn btn-primary" href="#">Read More</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="primary-btn text-center">
                        <a href="#" class="btn btn-primary">Download Schedule</a>
                    </div>
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