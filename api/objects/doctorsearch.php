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
        $fname = "*",
        $lname = "*",
        $city = "*",
        $area = "*",
        $specialty = "*",
        $insurance = "*",
        $yearsOfExperience = "*"
    ) {
        $doctors = array();

        // Build query
        $query = "SELECT * FROM doctor WHERE first_name LIKE :first_name AND last_name LIKE :last_name 
        AND state LIKE :city AND area LIKE :area AND specialty LIKE :specialty AND allow_insurance LIKE :insurance
        AND years_of_exp >= :yearsOfExperience";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        // Bind parameters

        $stmt->bindParam(":first_name", $fname);
        $stmt->bindParam(":last_name", $lname);
        $stmt->bindParam(":city", $city);
        $stmt->bindParam(":area", $area);
        $stmt->bindParam(":specialty", $specialty);
        $stmt->bindParam(":insurance", $insurance);
        $stmt->bindParam(":yearsOfExperience", $yearsOfExperience);


        // Execute statement
        $stmt->execute();
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Display results
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $doctor = array(
                'id' => $row['id'],
                'first_name' => $row['firstname'],
                'last_name' => $row['lastname'],
                'city' => $row['state'],
                'area' => $row['area'],
                'specialty' => $row['specialty'],
                'insurance' => $row['allow_insurance'],
                'years_of_exp' => $row['years_of_exp']
            );

            // Add the doctor to the array
            $doctors[] = $doctor;
        }
        return $doctors;
    }
}



$db = $database->getConnection();
$doctorsearch = new DoctorSearch($db);
$data = $doctorsearch->searchDoctors();

echo "<pre>";
print_r($data);
echo "</pre>";
