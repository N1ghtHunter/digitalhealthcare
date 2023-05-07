<?php

include_once "../config/database.php";
include_once "../objects/promocode.php";
$pc = $_POST['promo_code'];
$discount = $_POST['discount'];
$exp= $_POST['expiration_date'];

$database = new Database();
$db = $database->getConnection();

$promo = new PromoCode($db);

$result = $promo->savePromocode($pc,$discount,$exp);

if($result == -1){
	echo "error";
	exit();
}else{
	// echo $result;
	$promo->sendMailToUsers("zamzam2960@gmail.com",$pc,$discount,$exp);
}
?>