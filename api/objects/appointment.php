<?php

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
    function selectClinicsHospitalByDoctorId($doctorId)
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
    public function SelsctAppointment($id)
    {
        $appointment = array();

        // Build query
        $query = "SELECT DISTINCT 
        a.id as appointment_id,
        a.date,
        a.start_time,
        a.end_time,
        a.cost,
        c.id as clinic_id,
        c.address as clinic_address,
        c.name as clinic_name,
        h.id as hospital_id,
        h.name as hospital_name,
        h.address as hospital_address
    FROM appointments a
    LEFT JOIN clinic c ON a.clinic_id=c.id
    LEFT JOIN hospital h ON a.hospital_id = h.id
    WHERE a.doctor_id LIKE :id";
        $stmt = $this->conn->prepare($query);

        // bind parameters

        $stmt->bindParam(":id", $id);




        // Execute statement
        $stmt->execute();
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);


        // loop through rows and add to doctors array
        // loop through rows and add to doctors array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $appointment[] = $row;
        }

        return $appointment;
    }

    public function getFullByAppointmentId($id)
    {
        $appointment = array();

        // Build query
        $query = "SELECT DISTINCT 
        a.id as appointment_id,
        a.date,
        a.start_time,
        a.end_time,
        a.cost,
        a.clinic_id,
        a.hospital_id,
        c.id as clinic_id,
        c.address as clinic_address,
        c.name as clinic_name,
        c.phone_number as clinic_phone,
        h.id as hospital_id,
        h.name as hospital_name,
        h.address as hospital_address,
        h.phone_number as hospital_phone,
        d.id as id,
        d.full_name as doctor_name,
        d.specialty as specialty,
        d.state as state,
        d.area as area,
        d.years_of_exp as years_of_exp,
        d.allow_insurance as allow_insurance,
        d.allow_online_payment as allow_online_payment
        FROM appointments a
        LEFT JOIN clinic c ON a.clinic_id=c.id
        LEFT JOIN hospital h ON a.hospital_id = h.id
        inner JOIN doctor d ON a.doctor_id = d.id
        WHERE a.id LIKE :id";
        $stmt = $this->conn->prepare($query);

        // bind parameters

        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
            return $appointment;
        } else {
            return -1;
        }
    }


    public function deleteAppointment($id)
    {
        // Build query
        $query = "DELETE FROM appointments WHERE id like :id";
        $stmt = $this->conn->prepare($query);
        // bind parameters
        $stmt->bindParam(":id", $id);
        // Execute statement
        $stmt->execute();
        return true;
    }
    public function deleteAllAppointment($doctor_id)
    {
        // Build query
        $query = "DELETE FROM appointments WHERE doctor_id like :doctor_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":doctor_id", $doctor_id);
        // bind parameters
        $stmt->execute();
        return true;
    }
}






// $db = $database->getConnection();
// $doctorsearch = new Appointment($db);
// $test = $doctorsearch->SelsctAppointment(1);

// echo $doctorsearch->SelsctAppointment(1);
// echo "<pre>";
// print_r($test);
// echo "</pre>";