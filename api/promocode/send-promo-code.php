<?php

// Get the form data
$email = $_POST['email'];
$promo_code = $_POST['promo_code'];

// Compose the email message
$subject = 'Your Promo Code';
$message = "Hi,\n\nHere's your promo code: $promo_code\n\nUse it to get a discount on your next purchase!\n\nThanks,\nThe Admin";
$headers = 'From: admin@example.com' . "\r\n" .
    'Reply-To: admin@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

// Send the email
if (mail($email, $subject, $message, $headers)) {
	echo "Promo code sent successfully.";

} else {
	echo "Error sending promo code.";
}

?>