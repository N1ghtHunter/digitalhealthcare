<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Promo Code</title>
    <link rel="stylesheet" href="promocodes.css">
</head>

<body>
    <h1>Generate Promo Code</h1>
    <form method="post" action="../api/promocode/promocodes.php">
        <label for="promo-code">Promo Code:</label>
        <input type="text" id="promo-code" name="promo_code" value="<?php echo generate_promo_code(); ?>" readonly>
        <label for="discount">Discount:</label>
        <input type="number" id="discount" name="discount" min="10" max="100" step="5" required>
        <label for="expiration-date">Expiration Date:</label>
        <input type="date" id="expiration-date" name="expiration_date" required>
        <input type="submit" value="Generate">
    </form>
</body>

</html>
<?php

function generate_promo_code() {
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$promo_code = '';
	for ($i = 0; $i < 8; $i++) {
		$promo_code .= $chars[rand(0, strlen($chars) - 1)];
	}
	return $promo_code;
}

?>