<?php

class Payment
{

    private $conn;
    private $table_name = "payment";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createCash($payment_amount, $patient_id, $payment_method = "cash")
    {
        //payment_date is NOW	payment_method is cash	payment_amount 	patient_id paid	 false
        $query = "INSERT INTO " . $this->table_name . " SET payment_date = NOW(), payment_method = :payment_method, payment_amount = :payment_amount, patient_id = :patient_id, paid = false";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":payment_method", $payment_method);
        $stmt->bindParam(":payment_amount", $payment_amount);
        $stmt->bindParam(":patient_id", $patient_id);
        if ($stmt->execute()) {
            // last inserted id
            $last_id = $this->conn->lastInsertId();
            return $last_id;
        } else {
            return -1;
        }
    }

    public function CreateOnline($payment_amount, $patient_id, $payment_method = "online")
    {
        //payment_date is NOW	payment_method is online	payment_amount 	patient_id paid	 true
        $query = "INSERT INTO " . $this->table_name . " SET payment_date = NOW(), payment_method = :payment_method, payment_amount = :payment_amount, patient_id = :patient_id, paid = true";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":payment_method", $payment_method);
        $stmt->bindParam(":payment_amount", $payment_amount);
        $stmt->bindParam(":patient_id", $patient_id);
        if ($stmt->execute()) {
            // last inserted id
            $last_id = $this->conn->lastInsertId();
            return $last_id;
        } else {
            return -1;
        }
    }
}
