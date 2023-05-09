<?php
// check if method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Wrong method";
    return;
}
session_start();
session_unset();
session_destroy();
header("Location: ../../doctor/login.php");
exit();
