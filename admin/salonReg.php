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