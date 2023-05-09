<?php

class PaymentValidator {
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

  public function __construct($name, $email, $address, $city, $state, $zip, $card_number, $exp_month, $exp_year, $cvv) {
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
	//   error_reporting(E_ERROR | E_PARSE);
  $validator = new PaymentValidator($_POST["name"], $_POST["email"], $_POST["address"], $_POST["city"], $_POST["state"], $_POST["zip"], $_POST["card_number"], $_POST["exp_month"], $_POST["exp_year"], $_POST["cvv"]);

  // Validate form data and display message
  echo $validator->validate();
}

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
    <?php 
    session_start();
      if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
      }
      ?>
    <header>
        <!-- <div class="container"> -->
        <form action="/api/objects/payment.php" class="container" method="post">
            <div class="left">
                <h3>BILLING ADDRESS</h3>
                Full name
                <input type="text" name="name" placeholder="Enter name">
                Email
                <input type="text" name="email" placeholder="Enter email">

                Address
                <input type="text" name="address" placeholder="Enter address">

                City
                <input type="text" name="city" placeholder="Enter City">
                <div id="zip">
                    <label>
                        State
                        <select name="state">
                            <option>Choose State..</option>
                            <option>Cairo</option>
                            <option>Alexandria</option>
                            <option>Aswan</option>
                            <option>Luxor</option>
                        </select>
                    </label>
                    <label>
                        Zip code
                        <input type="number" name="zip" placeholder="Zip code">
                    </label>
                </div>
                <!-- </form> -->
            </div>
            <div class="right">
                <h3>PAYMENT</h3>
                <!-- <form action="/" method="post"> -->
                Accepted Card <br>
                <img src="image/card1.png" width="100">
                <img src="image/card2.png" width="50">
                <br><br>

                Credit card number
                <input type="text" name="card_number" placeholder="Enter card number">

                Exp month
                <input type="text" name="exp_month" placeholder="Enter Month">
                <div id="Zip">
                    <label>
                        Exp year
                        <select name="exp_year">
                            <option>Choose Year..</option>
                            <option>2022</option>
                            <option>2023</option>
                            <option>2024</option>
                            <option>2025</option>
                        </select>
                    </label>
                    <label>
                        CVV
                        <input type="number" name="cvv" placeholder="CVV">
                    </label>
                </div>
                <input type="submit" name="" value="Submit">
            </div>
        </form>
        <!-- </div> -->
        <!-- </div> -->
    </header>
</body>

</html>