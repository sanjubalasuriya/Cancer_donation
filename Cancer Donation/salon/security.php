<?php
session_start();

if(!$_SESSION['uname'] && !$_SESSION['role']){
    header('Location: ../login.php');
}





?>