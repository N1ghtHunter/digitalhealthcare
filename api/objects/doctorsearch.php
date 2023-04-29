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
        $fname = "",
        $lname = "",
        $city = "",
        $area = "",
        $specialty = "",
        $insurance = "0 or 1",
        $yearsOfExperience = 0
    ) {
        $doctors = array();

        // Build query
        $query = "SELECT * FROM doctor WHERE first_name LIKE :first_name AND last_name LIKE :last_name AND state LIKE :state AND area LIKE :area AND specialty LIKE :specialty" .
            ($insurance !== "0 or 1" ? " AND allow_insurance = :allow_insurance" : " ")
            . " AND years_of_exp >= :years_of_exp";
        $stmt = $this->conn->prepare($query);

        // bind parameters
        $first_name = "%$fname%";
        $last_name = "%$lname%";
        $state = "%$city%";
        $area = "%$area%";
        $specialty = "%$specialty%";
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":state", $state);
        $stmt->bindParam(":area", $area);
        $stmt->bindParam(":specialty", $specialty);
        // insurance is boolean
        if ($insurance !== "0 or 1") {
            $stmt->bindParam(":allow_insurance", $insurance, PDO::PARAM_BOOL);
        }
        $stmt->bindParam(":years_of_exp", $yearsOfExperience, PDO::PARAM_INT);


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
$data = $doctorsearch->searchDoctors(insurance: true);

echo "<pre>";
print_r($data);
echo "</pre>";
