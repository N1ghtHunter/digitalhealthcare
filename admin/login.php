<?php 
session_start();

    ?>
    <html>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <body>
	<section class="login">
		<div class="login_box">
			<div class="left">
			<div class="top_link"><a href="#"><img src="https://drive.google.com/u/0/uc?id=16U__U5dJdaTfNGobB_OpwAJ73vM50rPV&export=download" alt="">Return home</a></div>
				<div class="contact">
					<form name="form" action="..\api\admin\login.php" onsubmit="return isvalid()" method="POST">
						<h3>ADMIN LOG IN</h3>
						<input type="text" placeholder="USERNAME" name = "username" >
						<input type="password" placeholder="PASSWORD" name = "password">
						<button class="submit" name = "submit" >LET'S GO</button>
                        <?php if (isset($_SESSION['error'])) { ?>
                        <p class="error"><?php echo $_SESSION['error']; ?></p>
                        <?php
                            unset($_SESSION['error']);
                        } ?>
					</form>
				</div>
			</div>
			<div class="right">
				<div class="right-text">
					<h2>Vezetta</h2>
					<h5>A digital healthcare</h5>
				</div>
				
			</div>
		</div>
	</section>
	<script>
            function isvalid(){
                var username = document.form.username.value;
                var password = document.form.password.value;
                if(username.length=="" && password.length==""){
                    alert(" Error : please enter Username and Password !");
                    return false;
                }
                else if(username.length==""){
                    alert("  Error : please enter Username !");
                    return false;
                }
                else if(password.length==""){
                    alert("  Error : please enter Password !");
                    return false;
                }
                
            }
        </script>
</body>
</html>