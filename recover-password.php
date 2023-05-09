<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            background: radial-gradient(#06A3DA, #091E3E);
        }

        .height-100 {
            height: 100vh
        }

        .card {
            width: 400px;
            border: none;
            height: 300px;
            box-shadow: 0px 5px 10px 0px #d2dae3;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .card h6 {
            color: #06A3DA;
            font-size: 20px
        }

        .inputs input {
            width: 40px;
            height: 40px
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0
        }

        .card-2 {
            background-color: #fff;
            padding: 10px;
            width: 350px;
            height: 100px;
            bottom: -50px;
            left: 20px;
            position: absolute;
            border-radius: 5px
        }

        .card-2 .content {
            margin-top: 50px
        }

        .card-2 .content a {
            color: #06A3DA;
        }

        .form-control:focus {
            box-shadow: none;
            border: 2px solid #091E3E
        }

        .validate {
            border-radius: 20px;
            height: 40px;
            background-color: #091E3E;
            border: 1px solid #091E3E;
            width: 140px
        }

        .btn-danger {
            background-color: #06A3DA;
            border-color: #06A3DA;
        }

        .btn-danger:hover {
            background-color: #091E3E;
            border-color: #091E3E;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }
    $email = $_SESSION['email'];
    // show first 2 letters of email and last 4 letters of email before @ and the rest of the letters are replaced with *
    $email = substr($email, 0, 2) . str_repeat("*", strlen($email) - 6) . substr($email, -4);
    echo "<script>console.log('$email')</script>";
    ?>
    <div class="container height-100 d-flex justify-content-center align-items-center">
        <div class="position-relative">
            <div class="card p-2 text-center">
                <h6>Please enter the one time password <br> to recover your password</h6>
                <div> <span>A code has been sent to</span> <small>
                        <?php echo $email; ?>
                    </small> </div>
                <form method="POST" action="api/patient/verifyPwdOtp.php">
                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                        <input class="m-2 text-center form-control rounded" type="text" name="input-1" id="first" maxlength="1" />
                        <input class="m-2 text-center form-control rounded" type="text" name="input-2" id="second" maxlength="1" />
                        <input class="m-2 text-center form-control rounded" type="text" name="input-3" id="third" maxlength="1" />
                        <input class="m-2 text-center form-control rounded" type="text" name="input-4" id="fourth" maxlength="1" />
                        <input class="m-2 text-center form-control rounded" type="text" name="input-5" id="fifth" maxlength="1" />
                        <input class="m-2 text-center form-control rounded" type="text" name="input-6" id="sixth" maxlength="1" />
                    </div>
                    <!-- error p -->
                    <p id="error" class="text-danger">
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        }
                        ?>
                    </p>
                    <div class="mt-4">
                        <button class="btn btn-danger px-4 validate" id="validate" type="submit">Validate</button>
                    </div>
                </form>

            </div>
            <!-- <div class="card-2">
                <div class="content d-flex justify-content-center align-items-center"> <span>Didn't get the code</span>
                    <a href="#" class="text-decoration-none ms-3">Resend(1/3)</a>
                </div>
            </div> -->
        </div>
    </div>
    <script src="js/otp.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>