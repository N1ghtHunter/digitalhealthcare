<?php

class Reservation
{

    private $doctor_id;
    private $patient_id;
    private $cost;
    private $start_time;
    private $end_time;
    private $insurance;
    private $allow_online_payment;
    private $allow_insurance;
    private $clinic_id;
    private $hospital_id;
    private $payment_id;


    private $conn;
    private $table_name = "reservation";
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function AddReservation($date, $start_time, $end_time, $doctor_id, $patient_id, $payment_id, $clinic_id = "", $hospital_id = "")
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
        $query .= "date = :date, ";
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
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":payment_id", $payment_id);
        // Execute the query
        if ($stmt->execute()) {
            $payment_id = $this->conn->lastInsertId();

            return $payment_id;
        } else {
            return -1;
        }
    }

    public function getReservationsByPatientId($patient_id)
    {
        $query = "SELECT " .
            "reservation.id as reservation_id, 
        reservation.date as reservation_date,
        reservation.start_time as reservation_start_time,
        reservation.end_time as reservation_end_time,
        reservation.doctor_id as reservation_doctor_id,
        reservation.patient_id as reservation_patient_id,
        reservation.clinic_id as reservation_clinic_id,
        reservation.hospital_id as reservation_hospital_id,
        payment.id as payment_id,
        payment.payment_amount as payment_amount,
        payment.payment_method as payment_method,
        payment.payment_date as payment_date,
        payment.paid as payment_status,
        d.full_name as doctor_name "
            . " FROM " . $this->table_name . " inner join payment on reservation.payment_id = payment.id inner join doctor d on reservation.doctor_id = d.id WHERE reservation.patient_id = :patient_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":patient_id", $patient_id);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $reservations = array();
        foreach ($rows as $row) {
            $reservations[] = $row;
        }
        return $reservations;
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
