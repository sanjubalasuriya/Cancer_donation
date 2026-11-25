<<<<<<< HEAD
<?php
require_once __DIR__ . '/../helpers/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';
require_once __DIR__ . '/../helpers/id_generator.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/mailer.php';
require_once __DIR__ . '/../helpers/response.php';

start_secure_session();

if (empty($_SESSION['uname']) || ($_SESSION['role'] ?? '') !== 'admin') {
    json_response(false, 'Unauthorized.', [], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method not allowed.', [], 405);
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response(false, 'Session expired. Please refresh and try again.', [], 403);
}

$name = clean_input($_POST['name'] ?? '');
$address = clean_input($_POST['address'] ?? '');
$latRaw = clean_input($_POST['lat'] ?? '');
$lngRaw = clean_input($_POST['lng'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$lisence = clean_input($_POST['lisence'] ?? '');
$contact = clean_input($_POST['contact'] ?? '');

if ($name === '' || $address === '' || $latRaw === '' || $lngRaw === '' || $email === '' || $lisence === '' || $contact === '') {
    json_response(false, 'Please fill in all required fields.');
}

if (!is_valid_coordinate($latRaw, -90.0, 90.0) || !is_valid_coordinate($lngRaw, -180.0, 180.0)) {
    json_response(false, 'Please enter valid latitude (-90 to 90) and longitude (-180 to 180) coordinates.');
}

if (!is_valid_phone($contact)) {
    json_response(false, 'Contact number must be exactly 10 digits.');
}

if (!is_valid_email($email)) {
    json_response(false, 'Please enter a valid email address.');
}

$s_id = generate_next_id($con, 'salons', 's_id', 'SL_');
$lat = (float)$latRaw;
$lng = (float)$lngRaw;
$defaultPassword = '123456';
$hashedPass = hash_user_password($defaultPassword);
$roleSalon = 'salon';

mysqli_begin_transaction($con);

try {
    $stmt1 = mysqli_prepare(
        $con,
        'INSERT INTO `salons` (`s_id`, `name`, `address`, `lat`, `lng`, `email`, `lisence`, `contact`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    );
    if (!$stmt1) {
        throw new RuntimeException('Failed to prepare salon insert.');
    }
    mysqli_stmt_bind_param($stmt1, 'sssddsss', $s_id, $name, $address, $lat, $lng, $email, $lisence, $contact);
    if (!mysqli_stmt_execute($stmt1)) {
        throw new RuntimeException('Failed to save salon.');
    }
    mysqli_stmt_close($stmt1);

    $stmt2 = mysqli_prepare($con, 'INSERT INTO `login` (`uname`, `password`, `role`) VALUES (?, ?, ?)');
    if (!$stmt2) {
        throw new RuntimeException('Failed to prepare login insert.');
    }
    mysqli_stmt_bind_param($stmt2, 'sss', $s_id, $hashedPass, $roleSalon);
    if (!mysqli_stmt_execute($stmt2)) {
        throw new RuntimeException('Failed to create salon login account.');
    }
    mysqli_stmt_close($stmt2);

    mysqli_commit($con);
} catch (\Throwable $e) {
    mysqli_rollback($con);
    error_log('Salon registration error: ' . $e->getMessage());
    json_response(false, 'Could not register salon right now. Please try again.', [], 500);
}

$bodyHtml = '<p>Congratulations! Your salon has been registered as a hair donation partner with Save Life Cancer Foundation.</p>'
    . '<p><strong>Portal Username:</strong> ' . e($s_id) . '<br><strong>Temporary Password:</strong> ' . e($defaultPassword) . '</p>'
    . '<p>Please sign in and update your password from the Profile page.</p>';
$htmlBody = build_foundation_email($name, 'Partner Salon Account Created', $bodyHtml);
$mailResult = send_foundation_email($email, 'Save Life Foundation - Partner Salon Account', $htmlBody);

$msg = $mailResult['sent']
    ? 'Salon ' . $name . ' (' . $s_id . ') registered and credentials emailed.'
    : 'Salon ' . $name . ' (' . $s_id . ') registered successfully (default password: 123456).';

json_response(true, $msg, [
    'redirect' => 'salons.php',
    'email_sent' => $mailResult['sent'],
]);
=======
<link rel="stylesheet" type="text/css" href="style.css">

<?php 

include ('../db/db.php');
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer();

	$mail->isSMTP();

	$mail->Host = "smtp.gmail.com";

	$mail->SMTPAuth = true;

	$mail->SMTPSecure = "tls";

	$mail->Port = "587";

	$mail->Username = "savelifefoundationsl2@gmail.com";

	$mail->Password = "ywwelcmgxovhzxbp";


$s_id = $_POST["s_id"];
$name = $_POST["name"];
$address = $_POST["address"];
$lat = $_POST["lat"];
$lng = $_POST["lng"];
$email = $_POST["email"];
$lisence = $_POST["lisence"];
$contact = $_POST["contact"];


$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
$number = "/^[0-9]+$/";



if(empty($name) || empty($address) || empty($lat) || empty($lng) || empty($email)){


    echo "
            <div class=' alert-warning' role='alert'>
            
                      <b>  Fill All Fields...</b>
            </div>

    ";
    exit();
}
else{

  if(!preg_match($number,$contact)){

    echo "
            <div class=' alert-warning' role='alert'>
            
                      <b>  Invalid Contact...</b>
            </div>

    ";
    exit();
}

if(!preg_match($emailValidation,$email)){
  echo "
            <div class=' alert-warning' role='alert'>
            
                      <b>  Validate your email '$email'...</b>
            </div>

    ";
    exit();
}


if(!(strlen($contact) == 10)){
  echo "
            <div class=' alert-warning' role='alert'>
            
                      <b>  Contact length is Wrong...</b>
            </div>

    "; 
    exit();
}

    

$sql = "INSERT INTO `salons` (`id`, `s_id`, `name`, `address`, `lat`, `lng`, `email`, `lisence`, `contact`) 
VALUES (NULL, '$s_id', '$name', '$address', '$lat', '$lng', '$email', '$lisence', '$contact')";

$run_query = mysqli_query($con,$sql);


if($run_query){


  $sql2 = "INSERT INTO `login` (`id`, `uname`, `password`, `role`) 
  VALUES (NULL, '$s_id', md5('123456'), 'salon')";   

$run_query2 = mysqli_query($con,$sql2);

   // Email subject
	$mail->Subject = "Save Life Foundation";
    //Set sender email
        $mail->setFrom('savelifefoundationsl2@gmail.com');
    //Enable HTML
        $mail->isHTML(true);
    //Attachment
        //$mail->addAttachment('img/attachment.png');
    //Email body
    $mail->Body = "<!DOCTYPE html>
    <html lang='en'>
      <head>
        <meta charset='UTF-8' />
        <meta http-equiv='X-UA-Compatible' content='IE=edge' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
      </head>
      <body>
        <div style='text-align: center;
        color: #bd0000;
        background-color: #fff;
        align-items: center;
        padding-left: 25%;
        padding-right: 25%;
        font-size: 30px;'>
          <h1 style='font-size: 40px'>Save Life Cancer Foundation</h1>
        </div>
        <div style='text-align: center; 
        padding: 40px; 
        color: #000000;'>
          <center>
            <hr style='width: 50%'/>
            <h3 style='padding: 20px'>Hi $name,</h3>
            <p>Congratulations...</p>
            <p>You registered in Save Life Cancer Foundation.</p>
            <p>Username is : $s_id</p>
            <p>Password is : 123456</p>
            <h3>Thank You...!</h3>
            <hr style='width: 50%'/>
          </center>
        </div>
      </body>
    </html>";
    //Add recipient
        $mail->addAddress($email);

        //Finally send email
	if ( $mail->send() ) {

            
?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location.href = window.location.href;
}, 2000);
</script>
<?php

}else{
    echo "Message could not be sent. Mailer Error: ";
}
//Closing smtp connection
$mail->smtpClose();
        }
        
    

    
    }
    

?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
