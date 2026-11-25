<<<<<<< HEAD
<?php
require_once __DIR__ . '/../helpers/security.php';

start_secure_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_unset();
    session_destroy();
}

header('Location: ../login.php');
exit();
=======
<?php 
session_start();

if(isset($_POST['logout'])){
    session_destroy();
    unset($_SESSION['uname']);
    header('Location: ../login.php
    ');
}

?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
