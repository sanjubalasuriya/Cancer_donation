<<<<<<< HEAD
<?php
require_once __DIR__ . '/db/db.php';
require_once __DIR__ . '/helpers/security.php';
require_once __DIR__ . '/helpers/validation.php';
require_once __DIR__ . '/helpers/mailer.php';
require_once __DIR__ . '/helpers/response.php';

start_secure_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(false, 'Method not allowed.', [], 405);
}

if (!verify_csrf($_POST['csrf_token'] ?? '')) {
    json_response(false, 'Session expired. Please refresh the page and try again.', [], 403);
}

$email = clean_input($_POST['email1'] ?? '');
$nic = clean_input($_POST['nic1'] ?? '');
$amount = 1000;

if ($email === '' || $nic === '') {
    json_response(false, 'Please enter both your registered NIC and email address.');
}

if (!is_valid_email($email)) {
    json_response(false, 'Please enter a valid email address.');
}

$stmt = mysqli_prepare($con, 'SELECT `m_id`, `f_name`, `l_name`, `email` FROM `members` WHERE LOWER(`nic`) = LOWER(?) LIMIT 1');
if (!$stmt) {
    json_response(false, 'Unable to look up membership right now.', [], 500);
}
mysqli_stmt_bind_param($stmt, 's', $nic);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$member = $res ? mysqli_fetch_assoc($res) : null;
mysqli_stmt_close($stmt);

if (!$member) {
    json_response(false, 'No registered member was found with that NIC. Please register as a new member above.');
}

if (strcasecmp($member['email'], $email) !== 0) {
    json_response(false, 'The email address does not match the email registered for this NIC.');
}

$m_id = $member['m_id'];
$fullName = trim($member['f_name'] . ' ' . $member['l_name']);

mysqli_begin_transaction($con);

try {
    $donationType = 'member';
    $ins = mysqli_prepare($con, 'INSERT INTO `donations` (`key_id`, `status`, `amount`) VALUES (?, ?, ?)');
    if (!$ins) {
        throw new RuntimeException('Failed to prepare renewal insert.');
    }
    mysqli_stmt_bind_param($ins, 'ssi', $m_id, $donationType, $amount);
    if (!mysqli_stmt_execute($ins)) {
        throw new RuntimeException('Failed to insert renewal record.');
    }
    mysqli_stmt_close($ins);

    $upd = mysqli_prepare($con, "UPDATE `members` SET `status` = 'paid' WHERE `m_id` = ?");
    if ($upd) {
        mysqli_stmt_bind_param($upd, 's', $m_id);
        mysqli_stmt_execute($upd);
        mysqli_stmt_close($upd);
    }

    mysqli_commit($con);
} catch (\Throwable $e) {
    mysqli_rollback($con);
    error_log('Member renewal error: ' . $e->getMessage());
    json_response(false, 'Could not renew membership right now. Please try again.', [], 500);
}

$bodyHtml = '<p>Congratulations! Your Save Life Cancer Foundation membership (ID: <strong>' . e($m_id) . '</strong>) has been renewed for another year.</p>'
    . '<p>Renewal payment recorded: <strong>Rs. ' . number_format($amount) . '</strong>.</p>';
$htmlBody = build_foundation_email($fullName, 'Membership Renewed', $bodyHtml);
$mailResult = send_foundation_email($email, 'Save Life Foundation - Membership Renewed', $htmlBody);

$msg = $mailResult['sent']
    ? 'Membership renewed successfully! A confirmation email has been sent.'
    : 'Membership renewed successfully!';

json_response(true, $msg, [
    'redirect' => 'member.php',
    'email_sent' => $mailResult['sent'],
]);
=======
<link rel="stylesheet" type="text/css" href="index.css">

<?php 

include ('db/db.php');
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


$email = $_POST["email1"];

$nic = $_POST["nic1"];
$amount = $_POST["amount1"];

$name = "/^[A-Z][a-zA-Z]+$/";
$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
$number = "/^[0-9]+$/";





if(empty($email) || empty($nic) ){


    

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
    

    

$sql3 = "SELECT id FROM members WHERE nic = '$nic' LIMIT 1";
$check_query = mysqli_query($con, $sql3);
$count_emp = mysqli_num_rows($check_query);



if($count_emp > 0){

    $res=mysqli_query($con,"SELECT * FROM `members` WHERE nic='$nic'");  
    while($row=mysqli_fetch_array($res))
    {
        
        $m_id = $row['m_id'];
        
        
        
    }




    $sql2 = "INSERT INTO `donations` (`id`, `key_id`, `status`, `amount`) 
    VALUES (NULL, '$m_id', 'member', '$amount')";

    $run_query2 = mysqli_query($con,$sql2);


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
   <head>
     <meta charset='UTF-8' />
     <meta http-equiv='X-UA-Compatible' content='IE=edge' />
     <meta name='viewport' content='width=device-width, initial-scale=1.0' />
   </head>
   <body style='border: solid 2px #bd0000; padding: 10px'>
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
         <h3 style='padding: 20px'>Hi Amal,</h3>
         <p>Congratulations...</p>
         <p>You renewed your membership now in Save Life Cancer Foundation.</p>
         <p>Your membership valid for 1 year</p>
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
    window.location = "member.php";
}, 2000);
</script>
<?php
     }else{
         echo "Message could not be sent. Mailer Error: ";
     }
 //Closing smtp connection
     $mail->smtpClose();
 

    



    exit();
}



else{


    ?>
<script>
swal({
    title: "error!",
    text: "You are not register",
    icon: "error",
    button: "close!",
});
setTimeout(function() {
    window.location = "member.php";
}, 3000);
</script>
<?php


}
    
}
    

?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
