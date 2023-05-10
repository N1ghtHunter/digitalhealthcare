<?php
session_start();
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['role'] != 'patient' || !isset($_SESSION['id'])) {
//     header("Location: ../../login.php?error=unauthorized");
//     exit();
// }
// if user is not logged in , set logged_in to false
include_once "../api/objects/doctor.php";
include_once "../api/config/database.php";
$database = Database::getInstance();
$db = $database->getConnection();
$doctor = new Doctor($db);
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

$user = $doctor->readOne($id);
unset($user['password']);
//print_r($user);
?>


<!<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Doctor | Home</title>
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
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

		<!-- Template Stylesheet -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<!-- Libraries Stylesheet -->
		<link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
		<link href="../lib/animate/animate.min.css" rel="stylesheet">
		<link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
		<link href="../lib/twentytwenty/twentytwenty.css" rel="stylesheet" />

		<!-- Customized Bootstrap Stylesheet -->

		<!-- Template Stylesheet -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="../css/searchBar.css">
		<link href="../css/style.css" rel="stylesheet">
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
					<a href="home.php" class="nav-item nav-link active">Home</a>
					<a href="clinic.php" class="nav-item nav-link">Clinics</a>
					<a href="hospital.php" class="nav-item nav-link">Hospital</a>

					<a href="home.php#appform" class="nav-item nav-link">Appointment</a>
				</div>
				<a href="#searchform" class="btn text-dark"><i class="fa fa-search"></i></a>
				<!-- <a href="appointment.html" class="btn btn-primary py-2 px-4 ms-3">Appointment</a> -->
				<?php if (isset($_SESSION['doctor'])) : ?>
					<a href="profile.php" class="btn btn-primary py-2 px-4 ms-3">Profile</a>
					<form action="../api/shared/drLogout.php" method="POST" style="margin:0;">
						<button type="submit" class="btn btn-secondary py-2 px-4 ms-3">Logout</button>
					</form>
				<?php else : ?>
					<a href="login.php" class="btn btn-primary py-2 px-4 ms-3">Login</a>
				<?php endif; ?>


			</div>
		</nav>

		<form action="../api/doctor/update.php" method="POST" style="background-color: #eee;">
			<div class="container py-5">
				<div class="row d-flex justify-content-center">
					<div class="col-lg-8">
						<div class="card mb-4">
							<div class="card-body">
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">First Name</p>
									</div>
									<div class="col-sm-3">
										<input type="hidden" name="id" value="<?php echo $user['id']; ?>" disabled>
										<!-- <p class="text-muted mb-0">Johnatan Smith</p> -->
										<input class="mb-0" type="text" name="first_name" value="<?php echo $user['first_name']; ?>">
									</div>
									<div class="col-sm-3">
										<p class="mb-0">Last Name</p>
									</div>
									<div class="col-sm-3">
										<!-- <p class="text-muted mb-0">Johnatan Smith</p> -->
										<input class=" mb-0" type="text" name="last_name" value="<?php echo $user['last_name']; ?>">
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Email</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0"><?php echo $user['email']; ?></p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Phone</p>
									</div>
									<div class="col-sm-9">
										<input type="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>" required>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Gender</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0"><?php echo $user['gender']; ?></p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Specialty</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0"><?php echo $user['specialty']; ?></p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Years of experince</p>
									</div>
									<div class="col-sm-9">
										<input type="number" name="years_of_exp" value="<?php echo $user['years_of_exp']; ?>" required>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">City</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0"><?php echo $user['state']; ?></p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Area</p>
									</div>
									<div class="col-sm-9">
										<p class="text-muted mb-0"><?php echo $user['area']; ?></p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Allow Insurance</p>
									</div>
									<div class="col-sm-9">
										<select name="allow_insurance" id="allow_insurance" class="form-select" required>
											<option value="0" <?php if ($user['allow_insurance'] == 0) echo 'selected'; ?>>No</option>
											<option value="1" <?php if ($user['allow_insurance'] == 1) echo 'selected'; ?>>Yes</option>
										</select>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<p class="mb-0">Allow Online Payment</p>
									</div>
									<div class="col-sm-9">
										<select name="allow_online_payment" id="allow_online_payment" class="form-select" required>
											<option value="0" <?php if ($user['allow_online_payment'] == 0) echo 'selected'; ?>>No</option>
											<option value="1" <?php if ($user['allow_online_payment'] == 1) echo 'selected'; ?>>Yes</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="d-flex
			justify-content-center
			align-items-center
			">
					<input type="submit" class="btn btn-primary" value="Update">
				</div>
			</div>
		</form>

		<!-- Footer Start -->
		<div class="container-fluid bg-dark text-light py-5 wow fadeInUp mb-5" data-wow-delay="0.3s" style="margin-top: -75px;">
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
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
		</script>
	</body>

	</html>