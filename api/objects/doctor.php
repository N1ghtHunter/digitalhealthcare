<?php

//include_once '../config/database.php';
include_once 'user.php';

//$database = new Database();
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
    public function update($data){
        $query = "UPDATE " . this->table_name . " SET ";
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
        $query .="WHERE id =: id"; 

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
            // return the full user record
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } else {
            return -1;
        }
    }
} 
