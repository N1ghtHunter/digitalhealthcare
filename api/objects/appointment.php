<?php

include_once '../config/database.php';
$database = new Database();
class Appointment
{
    private $appDate;
    private $place;
    private $from;
    private $to;
    private $cost;
    private $doctorid;
    private $conn;
    private $table_name = "appointments";
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function AddAppointment($appDate, $clinic_id = "", $hospital_id = "", $doctor_id, $start_time, $end_time, $cost)
    {
        // Prepare the statement
        $query = "INSERT INTO " . $this->table_name . " SET ";
        $query .= "doctor_id=:doctor_id, ";
        $query .= "date=:appDate, ";
        $query .= "start_time=:start_time, ";
        $query .= "hospital_id=:hospital_id, ";
        $query .= "end_time=:end_time, ";
        $query .= "cost=:cost";
        $stmt = $this->conn->prepare($query);

        // Bind the parameters
        $stmt->bindParam(":doctor_id", $doctor_id);
        $stmt->bindParam(":date", $appDate);
        $stmt->bindParam(":start_time", $start_time);
        $stmt->bindParam(":clinic_id", $clinic_id);
        $stmt->bindParam(":hospital_id", $hospital_id);
        $stmt->bindParam(":end_time", $end_time);
        $stmt->bindParam(":cost", $cost);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
$db = $database->getConnection();
$doctorsearch = new Appointment($db);
echo $doctorsearch->AddAppointment("01/31/2022", "doky", "dada", 12, "4:5", "8:8", 200);
