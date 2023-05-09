<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wait for approval</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="px-4 py-5 my-5 text-center">
        <img class="d-block mx-auto mb-4 img-fluid" src="../image/logo1.png" alt="" width="350">
        <?php
        session_start();
        if (isset($_SESSION['message']) &&  $_SESSION['message'] == "Reservation successful!") {
            echo "<h1 class='display-5 fw-bold'>Reservation Confirmed</h1>";
        } else {
            echo "<h1 class='display-5 fw-bold'>Reservation Failed</h1>";
        }
        ?>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">
                Thank you for using our service, we will send you an email when your reservation is approved.
            </p>
            <a href="../home.php" class="btn btn-primary btn-lg">Back to home</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>