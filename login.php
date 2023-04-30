<?php
session_start();

$email = '';

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}

?>
<!-- create a singup form with required attributes -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .error {
        color: red;
        border: 1px solid red;
        padding: 5px;
        margin-bottom: 10px;
        background-color: #ffcccb;
        border-radius: 5px;
    }
    </style>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <section class="login">
        <div class="login_box">
            <div class="left">
                <div class="top_link"><a href="#"><img
                            src="https://drive.google.com/u/0/uc?id=16U__U5dJdaTfNGobB_OpwAJ73vM50rPV&export=download"
                            alt="">Return home</a></div>
                <div class="contact">

                    <form action="api/patient/create.php" method="POST">
                        <h3>SIGN IN</h3>
                        <input type="email" name="email" placeholder="Email *" value="<?php echo $email; ?>" required>
                        <?php if (isset($_SESSION['email_error'])) { ?>
                        <p class="error"><?php echo $_SESSION['email_error']; ?></p>
                        <?php
                            unset($_SESSION['email_error']);
                        } ?>
                        <!-- date -->
                        <input type="password" name="password" placeholder="Password" required>
                        <?php if (isset($_SESSION['password_error'])) { ?>
                        <p class="error"><?php echo $_SESSION['password_error']; ?></p>
                        <?php
                            unset($_SESSION['password_error']);
                        } ?>
                        <?php if (isset($_SESSION['error'])) { ?>
                        <p class="error"><?php echo $_SESSION['error']; ?></p>
                        <?php
                            unset($_SESSION['error']);
                        } ?>
                        <input id="submit" type="submit" value="Sign Up">
                        <p>Already have an account? <a href="login.php">Login</a></p>
                    </form>
                </div>
            </div>
            <div class="right">
                <div class="right-text">
                    <h2>Vezzeta</h2>
                    <h5>A DIGITAL HEALTH CARE APPLICATION</h5>
                    <p>
                        &#169; 2023 Vezzeta. All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    </section>
</body>

</html>