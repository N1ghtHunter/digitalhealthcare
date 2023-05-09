<?php
session_start();

//   $reservationData = array(
//   "date" => $date,
//   "start_time" => $start_time,
//   "end_time" => $end_time,
//   "doctor_id" => $doctor_id,
//   "patient_id" => $id,
//   "clinic_id" => $clinic_id,
//   "hospital_id" => $hospital_id,
//   "cost" => $cost,
// );
$reservationData = $_SESSION['reservationData'];

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false || $_SESSION['role'] != "patient" || !isset($_SESSION['patient']) || !$_SESSION['patient']) {
  echo '<script>alert("Something went wrong!")</script>';
  echo '<script>window.location.href = "/home.php";</script>';
}
if (!isset($_SESSION['reservationData'])) {
  echo '<script>alert("Something went wrong!")</script>';
  echo '<script>window.location.href = "/home.php";</script>';
}
if (!isset($_SESSION['reservationData']['cost'])) {
  echo '<script>alert("Something went wrong!")</script>';
  echo '<script>window.location.href = "/home.php";</script>';
}

//  extract every element in array from the query string

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Payment</title>
  <link rel="stylesheet" type="text/css" href="payment.css">
</head>

<body>
  <header>
    <!-- <div class="container"> -->
    <form action="/api/objects/paymentValidator.php" class="container" method="post">
      <div class="right">
        <h3>PAYMENT</h3>
        <!-- <form action="/" method="post"> -->
        Accepted Card <br>
        <img src="image/card1.png" width="100">
        <img src="image/card2.png" width="50">
        <br><br>
        <label for="card_number">Credit card number</label>
        <input id="card_number" type="text" name="card_number" placeholder="Enter card number">
        <label for="exp_month">Exp month</label>
        <select id="exp_month" name="exp_month">
          <!-- options all monthes with value from 1 to 12 -->
          <option selected disabled>Choose Month..</option>
          <option value="1">January</option>
          <option value="2">Febuary</option>
          <option value="3">March</option>
          <option value="4">April</option>
          <option value="5">May</option>
          <option value="6">June</option>
          <option value="7">July</option>
          <option value="8">Augest</option>
          <option value="9">September</option>
          <option value="10">October</option>
          <option value="11">Novemeber</option>
          <option value="12">December</option>
        </select>
        <div id="Zip">
          <label for="exp_year">
            Exp year
          </label>
          <select name="exp_year" id="exp_year">
            <option disabled selected>Choose Year..</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
          </select>
          <label for="cvv">
            CVV
          </label>
          <input type="text" name="cvv" id="cvv" placeholder="CVV">
        </div>
        <input type="submit" value="Pay <?php echo $_SESSION['reservationData']['cost']; ?>LE">
      </div>
      <div class="left">
        <h3>BILLING ADDRESS</h3>
        <label for="name">Full Name</label>
        <input type="text" name="name" placeholder="Enter name">
        <label for="address">Address</label>
        <input type="text" name="address" placeholder="Enter address">
        <label for="city">City</label>
        <input type="text" name="city" placeholder="Enter city">
        <!-- </form> -->
      </div>
    </form>

  </header>
</body>

</html>