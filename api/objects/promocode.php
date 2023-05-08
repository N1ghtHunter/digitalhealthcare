<?php
include_once '../config/database.php';
include_once '../shared/mailer.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions

$database = new Database();

$mail = new PHPMailer(true);

class PromoCode
{
  private $conn;
  private $table_name = "promocodes";
  private $promo_code;
  private $discount;
  private $expiration_date;

  public function __construct($db)
  {
    $this->conn = $db;
  }


  public function getPromoCode()
  {
    return $this->promo_code;
  }

  public function getDiscount()
  {
    return $this->discount;
  }

  public function getExpirationDate()
  {
    return $this->expiration_date;
  }

  public function savePromocode($pc, $discount, $exp)
  {

    $query = "INSERT INTO " . $this->table_name . " SET ";
    $query .= "promo_code=:pc, ";
    $query .= "discount_percentage=:discount, ";
    $query .= "end_date=:exp ";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":pc", $pc);
    $stmt->bindParam(":discount", $discount);
    $stmt->bindParam(":exp", $exp);

    if ($stmt->execute()) {
      return $this->conn->lastInsertId();
    } else {
      return -1;
    }
  }
  public function sendMailToUser($to, $promocode, $discount, $exp)
  {
    $mailer = new Mailer();
    // set the subject of the email
    $subject = "Don't miss out! Get " . $discount . "% off with promo code " . $promocode . " !";
    // build an html message body
    $message = '<html>
        <head>
          <style>
            body {
              background-color: #EEF9FF;
              color: #091E3E;
              font-family: Arial, sans-serif;
            }
            
            h1 {
              color: #06A3DA;
              font-size: 24px;
              margin-bottom: 0;
            }
            
            p {
              font-size: 16px;
              margin-top: 0;
            }
            
            .promo-code {
              background-color: #06A3DA;
              color: #EEF9FF;
              font-size: 20px;
              padding: 10px;
              text-align: center;
              margin: 20px 0;
            }
            
            .cta-button {
              background-color: #F57E57;
              color: #EEF9FF;
              display: inline-block;
              font-size: 16px;
              padding: 10px 20px;
              text-align: center;
              text-decoration: none;
            }
            
            .cta-button:hover {
              background-color: #091E3E;
            }
          </style>
        </head>
        <body>
          <h1>Get ' . $discount . '% off your next purchase!</h1>
          <p>Use promo code:</p>
          <div class="promo-code">' . $promocode . '</div>
          <p>Enter this code at checkout to receive ' . $discount . '% off your order. Hurry, this offer expires on ' . $exp . ' !</p>
<a href="http://localhost/login.php" class="cta-button">Book now</a>
</body>

</html>';
    // send email
    $result = $mailer->sendEmail(to: $to, subject: $subject, body: $message);
    return $result;
  }

  public function sendMailToAllUsers($to, $promocode, $discount, $exp)
  {
    $mailer = new Mailer();
    // set the subject of the email
    $subject = "Don't miss out! Get " . $discount . "% off with promo code " . $promocode . " !";
    // build an html message body
    $message = '<html>
        <head>
          <style>
            body {
              background-color: #EEF9FF;
              color: #091E3E;
              font-family: Arial, sans-serif;
            }
            
            h1 {
              color: #06A3DA;
              font-size: 24px;
              margin-bottom: 0;
            }
            
            p {
              font-size: 16px;
              margin-top: 0;
            }
            
            .promo-code {
              background-color: #06A3DA;
              color: #EEF9FF;
              font-size: 20px;
              padding: 10px;
              text-align: center;
              margin: 20px 0;
            }
            
            .cta-button {
              background-color: #F57E57;
              color: #EEF9FF;
              display: inline-block;
              font-size: 16px;
              padding: 10px 20px;
              text-align: center;
              text-decoration: none;
            }
            
            .cta-button:hover {
              background-color: #091E3E;
            }
          </style>
        </head>
        <body>
          <h1>Get ' . $discount . '% off your next purchase!</h1>
          <p>Use promo code:</p>
          <div class="promo-code">' . $promocode . '</div>
          <p>Enter this code at checkout to receive ' . $discount . '% off your order. Hurry, this offer expires on ' . $exp . ' !</p>
<a href="http://localhost/login.php" class="cta-button">Book now</a>
</body>

</html>';
    // send email
    $result = $mailer->sendEmails(to: $to, subject: $subject, body: $message);
    return $result;
    // create a new instance of PHPMailer
  }
}
