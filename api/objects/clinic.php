<?php

include_once '../config/database.php';
$database = new Database();

class Clinic {
    private $conn;
    private $table_name = "clinic";
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // create a new clinic 
   

    public function addClinic($name, $address, $phone_number, $doctor_id){
        // $query = "INSERT INTO clinic (name, address, phone_number, doctor_id) VALUES ('$name', '$address', '$phone_number', '$doctor_id')";
        $query = "INSERT INTO " . $this->table_name . " SET ";
        $query.= "name='$name',";
        $query.= "address='$address',";
        $query.= "phone_number='$phone_number',";
        $query.= "doctor_id='$doctor_id'";
        $stmt = $this->conn->prepare($query);
                // Execute the statement and return the user id if successful
                if ($stmt->execute()) {
                    return $this->conn->lastInsertId();
                } else {
                    return -1;
                }
    }

    public function getClinics(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $clinics = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $clinics;
        } else {
            return -1;
        }
    }
    
    public function getClinic($id){
        $query = "SELECT * FROM ".$this->table_name." WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $clinics = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $clinics [0];
        } else {
            return -1;
        }
    }
    public function updateClinic($id,$name,$address,$phone_number)
    {
        $query = "UPDATE clinic SET name = '$name', address = '$address', phone_number = '$phone_number' WHERE id = $id";
        $stmt = $this->conn->prepare($query);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return -1;
        }
    }
    public function deleteClinic($name, $address, $phone_number, $doctor_id){

        $id = $_POST["id"]; // $query = "INSERT INTO clinic (name, address, phone_number, doctor_id) VALUES ('$name', '$address', '$phone_number', '$doctor_id')";
        $sql = "DELETE FROM clinic WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            header("Location: ../../doctor/clinic.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
  
}
}
