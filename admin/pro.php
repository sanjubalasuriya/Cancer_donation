<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: settings.php');
    exit();
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    redirect_with_flash('settings.php', 'error', 'Session expired. Please try again.');
}

$uname = $_SESSION['uname'] ?? '';
$result = process_password_change(
    $con,
    $uname,
    (string) ($_POST['password'] ?? ''),
    (string) ($_POST['npass'] ?? ''),
    (string) ($_POST['cpass'] ?? '')
);

redirect_with_flash('settings.php', $result['ok'] ? 'success' : 'error', $result['message']);
=======

include('security.php');
include('../db/db.php'); 


if (isset($_SESSION['uname'])){

   if(isset($_POST['password']) && isset($_POST['npass']) && isset($_POST['cpass'])){

        function validate($data){
                $data = trim($data);
                $date = stripslashes($data);
                $data = htmlspecialchars($data);
                return $date;
        }

        $pass = validate($_POST['password']);
        $npass = validate($_POST['npass']);
        $cpass = validate($_POST['cpass']);

        if(empty($pass)){
                $_SESSION['error'] = 'Currunt password is required';
                
        }else if(empty($npass)){
                $_SESSION['error'] = 'New password is required';

        }else if(strlen($npass) <= 5){
                $_SESSION['error'] = 'Please add atleast 6 Characters';
                
                
        }else if($npass !== $cpass){
                $_SESSION['error'] = 'Confirm password does not match';

        
                
                
        }else{
                $pass = md5($pass);
                $npass = md5($npass);
                $uname = $_SESSION['uname'];

                $sql = "SELECT password FROM login WHERE uname='$uname' AND password='$pass'";
                $result = mysqli_query($con, $sql);
                if(mysqli_num_rows($result) === 1){
                        
                        $sql2 = "UPDATE login SET password='$npass' WHERE uname='$uname'";
                        mysqli_query($con, $sql2);
                        $_SESSION['success'] = 'Your passwort has been changed succssfully';

                        
                        
                }else{
                        $_SESSION['error'] = 'Incorrect password';
                        
                        
                }
        }

   }else{
           header("Location: settings.php");
           
   }
}

header("location: settings.php");

$con->close();
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
