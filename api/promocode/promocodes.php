<?php

include_once "../config/database.php";
include_once "../objects/promocode.php";
include_once "../objects/patient.php";
$pc = $_POST['promo_code'];
$discount = $_POST['discount'];
$exp = $_POST['expiration_date'];

$database = Database::getInstance();
$db = $database->getConnection();

$promo = new PromoCode($db);
$patient = new Patient($db);
$result = $promo->savePromocode($pc, $discount, $exp);

if ($result == -1) {
	echo "error";
	exit();
} else {
	if ($result != -1) {
		$res = $promo->sendMailToAllUsers($patient->getAllMails(), $pc, $discount, $exp);
		if ($res == true) {
			header("Location: ../../admin/promocode.php");
			exit();
		} else {
			header("Location: ../../admin/promocode.php");
			exit();
		}
	}
}
