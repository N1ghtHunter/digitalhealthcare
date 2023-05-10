<?php
//include_once '../config/database.php';
class Request

{
    public function __construct($db)
    {
        $this->conn = $db;
    }
    private $conn;
    public function selectAllRequest()
    {
        $requests = array();

        // Build query
        $query = "SELECT DISTINCT 
        r.id as request_id,
        r.request_date,
        r.request_status,
        d.full_name,
        d.phone_number,
        d.gender,
        d.area,
        d.state,
        d.years_of_exp,
        d.specialty
    FROM requests r
    LEFT JOIN doctor d ON r.doctor_id=d.id";
        $stmt = $this->conn->prepare($query);
        // Execute statement
        $stmt->execute();

        // loop through rows and add to doctors array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $requests[] = $row;
        }

        return $requests;
    }
    public function ApproveRequest($id)
    {
        // Build query
        $query = "UPDATE requests SET request_status = 1 WHERE doctor_id like :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        // bind parameters
        $stmt->execute();
        return true;
    }
}
