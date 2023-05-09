<?php

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
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
            // return the full user record
            $patient_id = $this->conn->lastInsertId();
            $row = $this->readOne($patient_id);
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
}
