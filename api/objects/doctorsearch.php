<?php
include_once '../objects/search.php';
include_once '../config/database.php';
$database = new Database();
class DoctorSearch implements search
{
    private $conn;
    private $table_name = "doctor";
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function searchDoctors(
        $name = "",
        $city = "",
        $area = "",

        // $insurance = "0 or 1",
        $specialty = ""

    ) {
        $doctors = array();

        // Build query
        $query = "SELECT DISTINCT d.id,
        d.first_name,
        d.last_name,
        d.gender,
        d.years_of_exp,
        d.specialty,
        d.allow_insurance,
        d.allow_online_payment,
        d.state,
        d.area,
        a.id as appointment_id,
        a.date,
        a.start_time,
        a.end_time,
        a.cost,
        c.id as clinic_id,
        c.address as clinic_address,
        c.phone_number as clinic_phone,
        c.name as clinic_name,
        h.id as hospital_id,
        h.name as hospital_name,
        h.address as hospital_address,
        h.phone_number as hospital_phone 
    FROM doctor d 
    INNER JOIN appointments a ON d.id = a.doctor_id 
    LEFT JOIN clinic c ON a.clinic_id = c.id
    LEFT JOIN hospital h ON a.hospital_id = h.id
 WHERE LOWER (full_name) LIKE :name  AND state LIKE :state AND area LIKE :area AND specialty LIKE :specialty "
            /* ($insurance !== "0 or 1" ? " AND allow_insurance = :allow_insurance" : " ")
            . " AND years_of_exp >= :years_of_exp";*/;
        $stmt = $this->conn->prepare($query);

        // bind parameters
        $name = "%$name%";
        $state = "%$city%";
        $area = "%$area%";
        $specialty = "%$specialty%";
        $stmt->bindParam(":name", $name);

        $stmt->bindParam(":state", $state);
        $stmt->bindParam(":area", $area);
        $stmt->bindParam(":specialty", $specialty);
        // // insurance is boolean
        // if ($insurance !== "0 or 1") {
        //     $stmt->bindParam(":allow_insurance", $insurance, PDO::PARAM_BOOL);
        // }
        // $stmt->bindParam(":years_of_exp", $yearsOfExperience, PDO::PARAM_INT);


        // Execute statement
        $stmt->execute();
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);


        // loop through rows and add to doctors array
        // loop through rows and add to doctors array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $doctors[] = $row;
        }

        return $doctors;
    }
}



$db = $database->getConnection();
$doctorsearch = new DoctorSearch($db);
$data = $doctorsearch->searchDoctors();

// echo "<pre>";
// print_r($data);
// echo "</pre>";
