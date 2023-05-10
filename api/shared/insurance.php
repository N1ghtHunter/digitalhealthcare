<?php

class Insurance
{
    private $conn;
    private $table_name = "insurances";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $insurances = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $insurance[] = $row;
        }
        return $insurance;
    }

    public function getDiscountByName($name)
    {
        $query = "SELECT discount_percent FROM " . $this->table_name . " WHERE name like :name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['discount_percent'];
    }
}
