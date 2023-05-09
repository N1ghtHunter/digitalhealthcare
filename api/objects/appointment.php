<?php

include_once '../config/database.php';
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

    public function AddAppointment($appDate, $doctor_id, $start_time, $end_time, $cost, $clinic_id = "", $hospital_id = "")
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
        $query .= "date = :appDate, ";
        $query .= "start_time = :start_time, ";
        $query .= "end_time = :end_time, ";
        $query .= "cost = :cost";
        $stmt = $this->conn->prepare($query);
        // Bind the values
        if ($clinic_id != "") {
            $stmt->bindParam(":clinic_id", $clinic_id);
        }
        if ($hospital_id != "") {
            $stmt->bindParam(":hospital_id", $hospital_id);
        }
        $stmt->bindParam(":doctor_id", $doctor_id);
        $stmt->bindParam(":appDate", $appDate);
        $stmt->bindParam(":start_time", $start_time);
        $stmt->bindParam(":end_time", $end_time);
        $stmt->bindParam(":cost", $cost);
        // Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function selectClinicsByDoctorId($doctorId)
    {
        $address = array();
        $query = "SELECT name FROM clinic WHERE doctor_id like :doctorId";
        //
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":doctorId", $doctorId);
        $stmt->execute();
        //$row = $stmt->fetch(PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $address[] = $row;
        }
        $query = "SELECT name FROM hospital WHERE doctor_id like :doctorId";
        //
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":doctorId", $doctorId);
        $stmt->execute();
        //$row = $stmt->fetch(PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $address[] = $row;
        }
        return $address;
    }

    function selectClinicIdByName($name)
    {
        $query = 'SELECT id FROM clinic WHERE name like :name';
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":name", $name);
        if ($stmt->execute()) {
            $clinic = $stmt->fetch(PDO::FETCH_ASSOC);

            return $clinic["id"];
        } else {
            return "";
        }
    }

    function selectHospitalIdByName($name)
    {
        $query = 'SELECT id FROM hospital WHERE name like :name';
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":name", $name);


        if ($stmt->execute()) {
            $hospital = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($hospital == null) {
                return "";
            }
            if ($hospital["id"] == null) {
                return "";
            }
            return $hospital["id"];
        } else {
            return "";
        }
    }
}





// $db = $database->getConnection();
// $doctorsearch = new Appointment($db);
// $test = $doctorsearch->selectClinicsByDoctorId(1);

//echo $doctorsearch->AddAppointment("2020-12-12", "", "", 1, "10:00:00", "11:00:00", 1000);
// echo "<pre>";
// print_r($test);
// echo "</pre>";