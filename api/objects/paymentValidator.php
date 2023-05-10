<?php
include_once '../config/database.php';
include_once 'payment.php';
include_once 'reservation.php';
include_once 'patient.php';


class PaymentValidator
{
  private $conn;
  private $table_name = "payment";
  private $name;
  private $email;
  private $address;
  private $city;
  private $state;
  private $zip;
  private $card_number;
  private $exp_month;
  private $exp_year;
  private $cvv;

  public function __construct($name, $address, $city,  $card_number, $exp_month, $exp_year, $cvv, $db)
  {
    $this->conn = $db;
    $this->name = $name;
    $this->address = $address;
    $this->city = $city;
    $this->card_number = $card_number;
    $this->exp_month = $exp_month;
    $this->exp_year = $exp_year;
    $this->cvv = $cvv;
  }

  public function validate()
  {
    // Validate form data
    $name = $this->test_input($this->name);
    // $email = $this->test_input($this->email)
    $address = $this->test_input($this->address);
    $city = $this->test_input($this->city);
    // $state = $this->test_input($this->state);
    // $zip = $this->test_input($this->zip);
    $card_number = $this->test_input($this->card_number);
    $exp_month = $this->test_input($this->exp_month);
    $exp_year = $this->test_input($this->exp_year);
    $cvv = $this->test_input($this->cvv);

    // Check if all fields are filled
    if (!empty($name) && !empty($address) && !empty($city) && !empty($card_number) && !empty($exp_month) && !empty($exp_year) && !empty($cvv)) {
      // Payment is successful
      return "Payment successful!";
    } else {
      // Display error message
      return "Please fill in all fields.";
    }
  }

  private function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  session_start();
  $database = Database::getInstance();
  $db = $database->getConnection();
  $validator = new PaymentValidator($_POST["name"], $_POST["address"], $_POST["city"],  $_POST["card_number"], $_POST["exp_month"], $_POST["exp_year"], $_POST["cvv"], $db);
  // Validate form data and display message
  $_SESSION['message'] = $validator->validate();
  if ($_SESSION['message'] == "Payment successful!") {
    // Insert payment into database
    $p = new Payment($db);
    $r = new Reservation($db);
    $reservationData = $_SESSION['reservationData'];
    $payment_id = $p->CreateOnline($reservationData['cost'], $reservationData['patient_id']);
    $result = $r->AddReservation($reservationData['date'], $reservationData['start_time'], $reservationData['end_time'], $reservationData['doctor_id'], $reservationData['patient_id'],  $payment_id, $reservationData['clinic_id'], $reservationData['hospital_id']);
    if ($result == -1) {
      $_SESSION['message'] = "Reservation failed!";
      header("Location: ../../payment/payment-confirmation.php");
    } else {
      // Send email to patient
      $patient = new Patient($db);
      $patient->sendReservationConfirmation($reservationData['patient_id'], $reservationData['date'], $reservationData['start_time'], $reservationData['end_time'], $reservationData['cost']);
      $_SESSION['message'] = "Reservation successful!";
      header("Location: ../../payment/payment-confirmation.php");
    }
  }
  // header("Location: ../../payment/payment.php");
  exit();
}
