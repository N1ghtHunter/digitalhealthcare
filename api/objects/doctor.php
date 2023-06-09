<?php


include_once 'user.php';
include_once __DIR__ . '/../shared/mailer.php';

class  Doctor extends User
{
    private $conn;
    private $table_name = "doctor";


    private $specialization;
    private $yearsOfExp;
    private $allowInsurance;
    private $allowOnlinePayment;


    public function getSpecialization()
    {
        return $this->specialization;
    }

    public function setSpecialization($specialization)
    {
        $this->specialization = $specialization;
    }

    public function getYearsOfExp()
    {
        return $this->yearsOfExp;
    }

    public function setYearsOfExp($yearsOfExp)
    {
        $this->yearsOfExp = $yearsOfExp;
    }



    public function getAllowInsurance()
    {
        return $this->allowInsurance;
    }

    public function setAllowInsurance($allowInsurance)
    {
        $this->allowInsurance = $allowInsurance;
    }

    public function getAllowOnlinePayment()
    {
        return $this->allowOnlinePayment;
    }

    public function setAllowOnlinePayment($allowOnlinePayment)
    {
        $this->allowOnlinePayment = $allowOnlinePayment;
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
        $stmt->execute();
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
        $specialty = $data['specialty'];
        $state = $data['state'];
        $area = $data['area'];
        $years_of_exp = $data['years_of_exp'];
        $allow_online_payment = $data['allow_online_payment'];
        $allow_insurance = $data['allow_insurance'];
        $password = $data['password'];
        // Create the SQL INSERT statement
        $query = "INSERT INTO " . $this->table_name . " SET ";
        $query .= "first_name=:first_name, ";
        $query .= "last_name=:last_name, ";
        $query .= "email=:email, ";
        $query .= "phone_number=:phone_number, ";
        $query .= "gender=:gender, ";
        $query .= "specialty=:specialty, ";
        $query .= "state=:state, ";
        $query .= "area=:area, ";
        $query .= "years_of_exp=:years_of_exp, ";
        $query .= "allow_online_payment=:allow_online_payment, ";
        $query .= "allow_insurance=:allow_insurance, ";
        $query .= "password=:password ";

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Bind the parameters
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone_number", $phone_number);
        $stmt->bindParam(":gender", $gender);
        $stmt->bindParam(":specialty", $specialty);
        $stmt->bindParam(":state", $state);
        $stmt->bindParam(":area", $area);
        $stmt->bindParam(":years_of_exp", $years_of_exp);
        $stmt->bindParam(":allow_online_payment", $allow_online_payment);
        $stmt->bindParam(":allow_insurance", $allow_insurance);
        $stmt->bindParam(":password", $password);

        // Execute the statement and return the user id if successful
        if ($stmt->execute()) {
            $dr_id = $this->conn->lastInsertId();
            // insert into requests table request_date, doctor_id
            $query2 = "INSERT INTO requests SET request_date = NOW(), doctor_id = ?";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->bindParam(1, $dr_id);
            if ($stmt2->execute()) {
                return $dr_id;
            } else {
                return -1;
            }
        }
    }

    public function login($data)
    {

        $email = $data['email'];
        $password = $data['password'];
        $query = "SELECT  
        d.id,
        d.first_name,
        d.last_name,
        d.gender,
        d.years_of_exp,
        d.specialty,
        d.allow_insurance,
        d.allow_online_payment,
        d.state,
        d.area,
        d.password,  
        r.request_status
        FROM " . $this->table_name . " d INNER JOIN requests r on r.doctor_id = d.id WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) {
                return $row['request_status'] == 1 ? $row : -1;
            } else {
                echo "passwords do not match";
                return false;
            }
        } else {
            echo "error";
            return false;
        }
    }

    public function SelsctAllDoctor()
    {
        $doctors = array();

        // Build query
        $query = "SELECT DISTINCT * FROM doctor";
        $stmt = $this->conn->prepare($query);
        // Execute statement
        $stmt->execute();

        // loop through rows and add to doctors array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $doctors[] = $row;
        }

        return $doctors;
    }
    public function deleteDoctor($id)
    {
        // Build query
        $query = "DELETE FROM doctor WHERE id like :id";
        $stmt = $this->conn->prepare($query);
        // bind parameters
        $stmt->bindParam(":id", $id);
        // Execute statement
        $stmt->execute();
        return true;
    }
    public function update($id, $first_name, $last_name, $phone_number, $years_of_exp, $allow_online_payment, $allow_insurance)
    {
        $query = "UPDATE " . $this->table_name . " SET first_name = ?, last_name = ?, phone_number = ?, years_of_exp = ?, allow_online_payment = ?, allow_insurance = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $first_name);
        $stmt->bindParam(2, $last_name);
        $stmt->bindParam(3, $phone_number);
        $stmt->bindParam(4, $years_of_exp);
        $stmt->bindParam(5, $allow_online_payment);
        $stmt->bindParam(6, $allow_insurance);
        $stmt->bindParam(7, $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function sendApproveEmail($dr)
    {
        $mailer = new Mailer();
        $subject = "Your regestration has been approved";
        $doctor_registration_email = '
<html>
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
      
      h3{
        color: #091E3E;
        font-size: 20px;
        margin-top: 0;
      }

      p {
        font-size: 16px;
        margin-top: 0;
      }
      
      .registration-details {
        background-color: #06A3DA;
        color: #EEF9FF;
        font-size: 20px;
        padding: 10px;
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
    <h1>Doctor Registration Confirmed</h1>
    <h3>Dear Dr. ' . $dr["full_name"] . '</h3>
    <p>Your registration as a doctor has been confirmed. Thank you for joining our platform.</p>
    <div class="registration-details">
        <p>Registration Details:</p>
        <ul>
            <li>Full Name: ' . $dr["full_name"] . '</li>
            <li>Specialization: ' . $dr['speciality'] . '</li>
            <li>Email: ' . $dr["email"] . '</li>
        </ul>
    </div>
    <p>Thank you for choosing our platform. We look forward to working with you!</p>
  </div>
  </body>
</html>';
        $mailer->sendEmail($dr['email'], $subject, $doctor_registration_email);
    }
}
