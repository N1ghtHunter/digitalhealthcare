<?php

include_once '../config/database.php';
include_once '../objects/reservation.php';

$database = Database::getInstance();
$db = $database->getConnection();
$reservation = new Reservation($db);

$id = $_POST['reservation_id'];

$reservation->delete($id);

header("Location: ../../all-reservation.php");
