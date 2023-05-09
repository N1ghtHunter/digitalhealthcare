<?php
include_once '../config/database.php';
$database = new Database();


class PaymentValidator {
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

    public function __construct($name, $email, $address, $city, $state, $zip, $card_number, $exp_month, $exp_year, $cvv,$db) {
    $this->conn = $db;
    $this->name = $name;
    $this->email = $email;
    $this->address = $address;
    $this->city = $city;
    $this->state = $state;
    $this->zip = $zip;
    $this->card_number = $card_number;
    $this->exp_month = $exp_month;
    $this->exp_year = $exp_year;
    $this->cvv = $cvv;
    }

    public function validate() {
      // Validate form data
    $name = $this->test_input($this->name);
    $email = $this->test_input($this->email);
    $address = $this->test_input($this->address);
    $city = $this->test_input($this->city);
    $state = $this->test_input($this->state);
    $zip = $this->test_input($this->zip);
    $card_number = $this->test_input($this->card_number);
    $exp_month = $this->test_input($this->exp_month);
    $exp_year = $this->test_input($this->exp_year);
    $cvv = $this->test_input($this->cvv);

      // Check if all fields are filled
    if (!empty($name) && !empty($email) && !empty($address) && !empty($city) && !empty($state) && !empty($zip) && !empty($card_number) && !empty($exp_month) && !empty($exp_year) && !empty($cvv)) {
        // Payment is successful
        return "Payment successful!";
    } else {
        // Display error message
        return "Please fill in all fields.";
    }
    }

    private function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  session_start();
  $db = $database->getConnection();

    $validator = new PaymentValidator($_POST["name"], $_POST["email"], $_POST["address"], $_POST["city"], $_POST["state"], $_POST["zip"], $_POST["card_number"], $_POST["exp_month"], $_POST["exp_year"], $_POST["cvv"],$db);

    // Validate form data and display message
    $_SESSION['message'] = $validator->validate();
    header("Location: ../../payment/payment.php");
  exit();
}

?>