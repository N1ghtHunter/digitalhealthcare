<?php
session_start();


// if (!isset($_SESSION['id'])) {
//     header("Location: login.php");
//     exit();
// }

?>
<!-- create a singup form with required attributes -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
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
    <link rel="stylesheet" href="css/loginStyle.css">
</head>

<body>
    <section class="login">
        <div class="login_box">
            <div class="left">
                <div class="contact">
                    <form id="form" action="api/patient/resetPwd.php" method="POST">
                        <h3>Reset Password </h3>
                        <input id="password" type="password" name="password" placeholder="Password" required>
                        <input id="confirm_password" type="password" name="confirm_password"
                            placeholder="Confirm Password" required>
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
                        <input id="submit" type="submit" value="Reset You Password">
                    </form>
                </div>
            </div>
            <div class="right">
                <div class="right-text">
                    <h2>Ek4fly</h2>
                    <h5>A DIGITAL HEALTH CARE APPLICATION</h5>
                    <p>
                        &#169; 2023 Ek4fly. All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <script>
    const password = document.getElementById("password");
    const regEx = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%#*?&]{8,}$/;
    password.addEventListener("keyup", function(event) {
        // track input password value 
        const passwordValue = password.value;
        // check if password is valid
        if (regEx.test(passwordValue)) {
            password.style.outline = "none";
            password.style.borderRadius = "5px";
            password.style.border = "2px solid green";
            // set border radius to 5px
        } else {
            password.style.outline = "none";
            password.style.borderRadius = "5px";
            password.style.border = "2px solid red";

        }
    });
    const confirm_password = document.getElementById("confirm_password");
    confirm_password.addEventListener("keyup", function(event) {
        // track input password value 
        const passwordValue = password.value;
        const confirm_passwordValue = confirm_password.value;
        // check if password is valid
        if (passwordValue === confirm_passwordValue) {
            confirm_password.style.outline = "none";
            confirm_password.style.borderRadius = "5px";
            confirm_password.style.border = "2px solid green";

        } else {
            confirm_password.style.outline = "none";
            confirm_password.style.borderRadius = "5px";
            confirm_password.style.border = "2px solid red";

        }
    });

    const form = document.getElementById("form");

    form.addEventListener("submit", function(event) {
        const passwordValue = password.value;
        const confirm_passwordValue = confirm_password.value;
        if (passwordValue !== confirm_passwordValue || !regEx.test(passwordValue) || !regEx.test(
                confirm_passwordValue)) {
            event.preventDefault();
            alert(
                "Password and Confirm Password must match and must contain at least one number, one uppercase and lowercase letter, one special character and at least 8 or more characters");
        }
    });
    </script>
</body>

</html>