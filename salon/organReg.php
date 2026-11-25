<<<<<<< HEAD
<?php
require_once __DIR__ . '/../helpers/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';
require_once __DIR__ . '/../helpers/mailer.php';
require_once __DIR__ . '/../helpers/response.php';

start_secure_session();

if (empty($_SESSION['uname']) || ($_SESSION['role'] ?? '') !== 'salon') {
    json_response(false, 'Unauthorized. Please sign in as a salon partner.', [], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method not allowed.', [], 405);
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response(false, 'Session expired. Please refresh the page and try again.', [], 403);
}

$salonId = $_SESSION['uname'];
$f_name = clean_input($_POST['f_name'] ?? '');
$l_name = clean_input($_POST['l_name'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$dob = clean_input($_POST['dob'] ?? '');
$contact = clean_input($_POST['contact'] ?? '');
$nic = clean_input($_POST['nic'] ?? '');
$gender = clean_input($_POST['gender'] ?? '');

if ($f_name === '' || $l_name === '' || $email === '' || $contact === '' || $nic === '' || $dob === '' || $gender === '') {
    json_response(false, 'Please fill in all required fields.');
}

if (!is_valid_phone($contact)) {
    json_response(false, 'Contact number must be a valid 10-digit phone number.');
}

if (!is_valid_email($email)) {
    json_response(false, 'Please enter a valid email address.');
}

if (!is_valid_nic($nic)) {
    json_response(false, 'Please enter a valid NIC number (e.g. 901711671V or 12 digits).');
}

if (!in_array($gender, ['Male', 'Female'], true)) {
    json_response(false, 'Please select a valid gender.');
}

$statusPending = 'pending';
$stmt = mysqli_prepare(
    $con,
    'INSERT INTO `organ` (`salon_id`, `f_name`, `l_name`, `email`, `contact`, `nic`, `dob`, `gender`, `request`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
);
if (!$stmt) {
    json_response(false, 'Unable to register hair donation right now.', [], 500);
}

mysqli_stmt_bind_param($stmt, 'sssssssss', $salonId, $f_name, $l_name, $email, $contact, $nic, $dob, $gender, $statusPending);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if (!$ok) {
    error_log('Hair donation insert error: ' . mysqli_error($con));
    json_response(false, 'Failed to save hair donation request. Please try again.', [], 500);
}

$bodyHtml = '<p>Thank you for donating hair through our partner salon (<strong>' . e($salonId) . '</strong>).</p>'
    . '<p>Your request has been received and your appreciation certificate will be sent once approved by Save Life Cancer Foundation.</p>';
$htmlBody = build_foundation_email($f_name . ' ' . $l_name, 'Hair Donation Request Received', $bodyHtml);
$mailResult = send_foundation_email($email, 'Save Life Foundation - Hair Donation Received', $htmlBody);

$msg = $mailResult['sent']
    ? 'Hair donation request submitted and confirmation email sent to donor.'
    : 'Hair donation request submitted successfully.';

json_response(true, $msg, [
    'redirect' => 'index.php',
    'email_sent' => $mailResult['sent'],
]);
=======
<link rel="stylesheet" type="text/css" href="index.css">

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

$f_name = $_POST["f_name"];
$l_name = $_POST["l_name"];
$email = $_POST["email"];
$dob = $_POST["dob"];
$contact = $_POST["contact"];
$nic = $_POST["nic"];
$gender = $_POST["gender"];

$name = "/^[A-Z][a-zA-Z]+$/";
$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
$number = "/^[0-9]+$/";




if(empty($f_name) || empty($l_name) || empty($email) || empty($contact) || empty($nic) || empty($dob) || empty($gender)){


    

    ?>
<script>
swal({
    title: "error!",
    text: "Fill all Feilds!",
    icon: "error",
    button: "close!",
});
</script>

<?php 

    exit();
}else{
    
    if(!preg_match($number,$contact)){
        ?>
<script>
swal({
    title: "error!",
    text: "Contact number is Invalid",
    icon: "error",
    button: "close!",
});
</script>

<?php 
        exit();
    }
    
    if(!preg_match($emailValidation,$email)){
        ?>
<script>
swal({
    title: "error!",
    text: "Emai is Invalid!",
    icon: "error",
    button: "close!",
});
</script>

<?php 
        exit();
    }
    

    if(!(strlen($contact) == 10)){
        ?>
<script>
swal({
    title: "error!",
    text: "Contact number is Invalid!",
    icon: "error",
    button: "close!",
});
</script>

<?php 
        exit();
    }

else{

$sql = "INSERT INTO `organ` (`id`, `salon_id`, `f_name`, `l_name`, `email`, `contact`, `nic`, `dob`,  `gender` , `request`) 
VALUES (NULL, '1', '$f_name', '$l_name', '$email', '$contact', '$nic','$dob','$gender', 'pending' )";




$run_query = mysqli_query($con,$sql);
if($run_query){

    



//Email subject
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
  <head style='border: solid 2px #bd0000; padding: 10px'>
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
        <h3 style='padding: 20px'>Hi $f_name,</h3>
        <p>Congratulations...</p>
        <p>Your request is sent... Certificate will be send soon</p>
        
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
<script>
swal({
    title: "Success!",
    text: "You clicked the button!",
    icon: "success",

});
setTimeout(function() {
    window.location = "index.php";
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
    
}
    

?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
