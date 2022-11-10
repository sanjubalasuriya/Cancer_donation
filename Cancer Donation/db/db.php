<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "cancer";

$con = mysqli_connect($servername, $username, $password, $db);

if (!$con) {
    die("Connection faild: " .mysqli_connect_error());
}

?>