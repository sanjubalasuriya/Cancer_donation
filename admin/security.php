<?php
<<<<<<< HEAD
require_once __DIR__ . '/../helpers/security.php';
require_auth('admin', '../login.php');
=======

session_start();

if(!$_SESSION['uname'] ){
    header('Location: ../login.php');
}





?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
