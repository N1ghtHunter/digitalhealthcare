<?php

include_once '../config/database.php';
$database = new Database();
class Reservation {
   
    private $doctor_id;
    private $patient_id ;
    private $cost ;
    private $start_time ;
    private $end_time ;
    private $insurance ;
    private $allow_online_payment ;
    private $allow_insurance ;
    private $clinic_id ;
    private $hospital_id ;
    private $payment_id ;

   
    private $conn;
    private $table_name = "reservation";
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function AddReservation($start_time, $end_time, $doctor_id, $patient_id , $payment_id, $clinic_id = "", $hospital_id = "")
    {
        // Prepare the statement
        $query = "INSERT INTO " . $this->table_name . " SET ";
        if ($clinic_id != "") {
            $query .= "clinic_id = :clinic_id, ";
        }
        if ($hospital_id != "") {
            $query .= "hospital_id = :hospital_id, ";
        }
        $query .= "doctor_id = :doctor_id, ";
        $query .= "patient_id = :patient_id, ";
        $query .= "start_time = :start_time, ";
        $query .= "end_time = :end_time, ";
        $query .= "payment_id = :payment_id";
        $stmt = $this->conn->prepare($query);
        // Bind the values
        if ($clinic_id != "") {
            $stmt->bindParam(":clinic_id", $clinic_id);
        }
        if ($hospital_id != "") {
            $stmt->bindParam(":hospital_id", $hospital_id);
        }
        $stmt->bindParam(":doctor_id", $doctor_id);
        $stmt->bindParam(":patient_id", $patient_id);
        $stmt->bindParam(":start_time", $start_time);
        $stmt->bindParam(":end_time", $end_time);
        $stmt->bindParam(":payment_id", $payment_id);
        // Execute the query
        if ($stmt->execute()) {
            $payment_id = $this->conn->lastInsertId();
            
            return $payment_id;
        } else {
            return -1;
        }
    }

}