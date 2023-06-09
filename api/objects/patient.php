<?php

include_once 'user.php';
include_once __DIR__ . '/../shared/mailer.php';


class  Patient extends User
{
  private $conn;
  private $table_name = "patient";

  private $insuranceInfo;
  private $bloodType;

  public function getInsuranceInfo()
  {
    return $this->insuranceInfo;
  }

  public function setInsuranceInfo($insuranceInfo)
  {
    $this->insuranceInfo = $insuranceInfo;
  }

  public function getBloodType()
  {
    return $this->bloodType;
  }

  public function setBloodType($bloodType)
  {
    $this->bloodType = $bloodType;
  }

  public function __construct($db)
  {
    $this->conn = $db;
  }

  // implement abstract methods

  public function emailExists($email)
  {
    // make query to check if email exists in the database and return true or false 
    $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function readOne($id)
  {
    $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $id);
    if (!$stmt->execute()) {
      return -1;
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
  }

  public function create($data)
  {
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $email = $data['email'];
    $phone_number = $data['phone_number'];
    $gender = $data['gender'];
    $insurance_info = $data['insurance_info'];
    $age = $data['age'];
    $blood_type = $data['blood_type'];
    $date_of_birth = $data['date_of_birth'];
    $password = $data['password'];
    // Create the SQL INSERT statement
    $query = "INSERT INTO " . $this->table_name . " SET ";
    $query .= "first_name=:first_name, ";
    $query .= "last_name=:last_name, ";
    $query .= "email=:email, ";
    $query .= "phone_number=:phone_number, ";
    $query .= "gender=:gender, ";
    $query .= "insurance_info=:insurance_info, ";
    $query .= "age=:age, ";
    $query .= "blood_type=:blood_type, ";
    $query .= "date_of_birth=:date_of_birth, ";
    $query .= "password=:password";

    // Prepare the statement
    $stmt = $this->conn->prepare($query);

    // Bind the parameters
    $stmt->bindParam(":first_name", $first_name);
    $stmt->bindParam(":last_name", $last_name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone_number", $phone_number);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":insurance_info", $insurance_info);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":blood_type", $blood_type);
    $stmt->bindParam(":date_of_birth", $date_of_birth);
    $stmt->bindParam(":password", $password);

    // Execute the statement and return the user id if successful
    if ($stmt->execute()) {
      // return the last inserted record
      $id = $this->conn->lastInsertId();
      $row = $this->readOne($id);

      return $row;
    } else {
      return -1;
    }
  }

  public function login($data)
  {
    $email = $data['email'];
    $password = $data['password'];
    $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // verify password hash
    if (password_verify($password, $row['password'])) {
      return $row;
    } else {
      return false;
    }
  }

  public function getAllMails()
  {
    $query = "SELECT email FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $emails = array();
    foreach ($row as $r) {
      array_push($emails, $r['email']);
    }
    return $emails;
  }

  public function generateOTP($email)
  {
    $otp = rand(100000, 999999);
    $query = "UPDATE " . $this->table_name . " SET otp = ? WHERE email = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $otp);
    $stmt->bindParam(2, $email);
    if ($stmt->execute()) {
      return $otp;
    } else {
      return false;
    }
  }

  public function sendOTP($otp, $email)
  {
    $mailer = new Mailer();
    $subject = "Verify your email";
    $body = '<html>
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
            
            .otp-code {
              background-color: #06A3DA;
              color: #EEF9FF;
              font-size: 20px;
              padding: 10px;
              text-align: center;
              margin: 20px 0;
            }
          </style>
        </head>
        <body>
        <div style="text-align: center;">
       <img 
       style="width: 200px; margin:0 auto; display: block;"
       alt="Logo" src="cid:logo">
          <h1>Verify Your Account</h1>
          <p>Use the following OTP code to verify your account:</p>
          <div class="otp-code">' . $otp . '</div>
          </div>
            </body>
        </html>';
    $res = $mailer->sendEmail(to: $email, subject: $subject, body: $body);
    return $res;
  }

  public function verifyOTP($otp, $email)
  {
    $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['otp'] == $otp) {
      $query = "UPDATE " . $this->table_name . " SET isVerified = 1 WHERE email = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $email);
      if ($stmt->execute()) {
        return $row['id'];
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function verifyRecoverPwdOtp($otp, $email)
  {
    $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row['otp'] == $otp) {
      return $row['id'];
    } else {
      return -1;
    }
  }

  public function sendRecoverPassword($otp, $email)
  {
    $mailer = new Mailer();
    $subject = "Recover your password";
    $reset_password_email = ' <html>
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
      
      .otp-code {
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
  <div style="text-align: center;">
  <img 
  style="width: 200px; margin:0 auto; display: block;"
  alt="Logo" src="cid:logo">
    <h1>Reset your password</h1>
    <p>Use the following OTP code to reset your password:</p>
    <div class="otp-code">' . $otp . '</div>
    <p>If you did not request a password reset, please ignore this email.</p>
    </div>
        </body>
    </html>';
    $body = $reset_password_email;
    $res = $mailer->sendEmail(to: $email, subject: $subject, body: $body);
    return $res;
  }

  public function resetPassword($id, $password)
  {
    $query = "UPDATE " . $this->table_name . " SET password = ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $password);
    $stmt->bindParam(2, $id);
    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function sendReservationConfirmation($id, $date, $start_time, $end_time, $cost)
  {
    $patient = $this->readOne($id);
    $mailer = new Mailer();
    $subject = "Reservation Confirmation";
    $reservation_confirmation_email = '<html>
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
      
      .reservation-details {
        background-color: #06A3DA;
        color: #EEF9FF;
        font-size: 20px;
        padding: 10px;
        margin: 20px 0;
        text-align: left;
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
  <div style="text-align: center;">
  <img 
  style="width: 200px; margin:0 auto; display: block;"
  alt="Logo" src="cid:logo">
    <h1>Reservation Confirmed</h1>
    <p>Your reservation for ' . $date . ' from ' . $start_time . ' to ' . $end_time . ' has been confirmed. The total cost of your reservation is $' . $cost . '.</p>
    <div class="reservation-details">
        <p>Reservation Details:</p>
        <ul>
            <li>On: ' . $date . '</li>
            <li>From: ' . $start_time . '</li>
            <li>To: ' . $end_time . '</li>
            <li>Total Cost: ' . $cost . ' LE </li>
        </ul>
    </div>
    <p>Thank you for choosing our service. We look forward to seeing you soon!</p>
  </div>
  </body>
</html>';
    $body = $reservation_confirmation_email;
    $res = $mailer->sendEmail(to: $patient['email'], subject: $subject, body: $body);
    return $res;
  }

  public function update($id, $first_name, $last_name, $phone_number, $insurance_info, $date_of_birth)
  {

    $query = "UPDATE " . $this->table_name . " SET first_name = ?, last_name = ?, phone_number = ?, insurance_info = ?, date_of_birth = ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $first_name);
    $stmt->bindParam(2, $last_name);
    $stmt->bindParam(3, $phone_number);
    $stmt->bindParam(4, $insurance_info);
    $stmt->bindParam(5, $date_of_birth);
    $stmt->bindParam(6, $id);
    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function SelsctAllPatient()
  {
    $patients = array();

    // Build query
    $query = "SELECT DISTINCT * FROM patient";
    $stmt = $this->conn->prepare($query);
    // Execute statement
    $stmt->execute();

    // loop through rows and add to doctors array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $patients[] = $row;
    }

    return $patients;
  }
  public function deletePatient($id)
  {
    // Build query
    $query = "DELETE FROM patient WHERE id like :id";
    $stmt = $this->conn->prepare($query);
    // bind parameters
    $stmt->bindParam(":id", $id);
    // Execute statement
    $stmt->execute();
    return true;
  }
}
