<?php
session_start();


$comment = '';
$rate = '';


if (isset($_SESSION['rate'])) {
    $firstname = $_SESSION['rate'];
}
if (isset($_SESSION['comment'])) {
    $lastname = $_SESSION['commemt'];
}

?>


<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/-->
<!DOCTYPE html>
<html>
<head>
<title>FeedbacK Engine</title>
<!-- custom-theme -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Elegant Feedback Form  Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //custom-theme -->
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
<link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
</head>
<body class="agileits_w3layouts">
    <h1 class="agile_head text-center">Feedback Form</h1>
    <div class="w3layouts_main wrap">
	  <h3>Please help us to serve you better by taking a couple of minutes. </h3>
	    <form action="feedback.php" method="post" class="agile_form">
		  <h2>How satisfied were you with our Service?</h2>
			 <ul class="agile_info_select">
				 <li><input type="radio" name="view" value="5" id="excellent" required> 
				 	  <label for="excellent">5</label>
				      <div class="check w3"></div>
				 </li>
				 <li><input type="radio" name="view" value="4" id="good"> 
					  <label for="good"> 4</label>
				      <div class="check w3ls"></div>
				 </li>
				 <li><input type="radio" name="view" value="3" id="neutral">
					 <label for="neutral">3</label>
				     <div class="check wthree"></div>
				 </li>
				 <li><input type="radio" name="view" value="2" id="poor"> 
					  <label for="poor">2</label>
				      <div class="check w3_agileits"></div>
				 </li>
				 <li><input type="radio" name="view" value="1" id="very poor"> 
					  <label for="very poor">1</label>
				      <div class="check w3_agileits"></div>
				 </li>
			 </ul>	  
			<h2>If you have specific feedback, please write to us...</h2>
			<textarea placeholder="Additional comments" class="w3l_summary" name="comments" required=""></textarea>
			
			<center><input type="submit" value="submit Feedback" class="agileinfo" /></center>
	  </form>
	</div>
	<div class="agileits_copyright text-center">
			<p>© 2019 </p>
	</div>
</body>
</html>

