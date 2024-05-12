<?php
include('header.php');






require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Hair Donate request List</h1>


    </div>
    <hr>

    <div class="container_body">
        <div class="details_table">


            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>NIC</th>
                        <th>Status</th>
                        <th>Edit</th>


                    </tr>
                </thead>
                <?php 
                $res=mysqli_query($con,"SELECT * FROM `organ` WHERE request='pending'");
                while($row=mysqli_fetch_array($res))
                {

                    
                    

                ?>

                <tbody>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["f_name"]; ?></td>
                        <td><?php echo $row["l_name"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["nic"]; ?></td>
                        <td><?php echo $row["request"]; ?></td>

                        <td>
                            <input type="hidden" class="delete_id_value" value="<?php echo $row["id"]; ?>">
                            <a href="javascripit:void(0)" class="delete_btn_ajax action edit">Sent</a>

                        </td>

                    </tr>

                </tbody>

                <?php 
                }
                ?>

            </table>

        </div>

    </div>

</div>

<script>
$(document).ready(function() {

    $('.delete_btn_ajax').click(function(e) {
        e.preventDefault();
        var deleteid = $(this).closest("tr").find('.delete_id_value').val();
        //console.log(deleteid);


        swal({
                title: "Are you sure?",
                text: "Do you want to sent Certificate?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        type: "POST",
                        url: "",
                        data: {
                            "delete_btn_set": 1,
                            "delete_id": deleteid,
                        },

                        success: function(response) {

                            swal("PDF sent Successfully.!", {
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });
                }
            });
    });

});
</script>

<?php
 
  if(isset($_POST['delete_btn_set']))

  {
      $del_id = $_POST['delete_id'];

      $reg_query = "UPDATE `organ` SET `request`='sent' WHERE id='$del_id'";
      $reg_query_run = mysqli_query($con, $reg_query);

      $res=mysqli_query($con,"SELECT * FROM `organ` WHERE id=$del_id");  
        while($row=mysqli_fetch_array($res))
        {
            
            $email = $row["email"];
            $f_name = $row["f_name"];
            $l_name = $row["l_name"];
            
            
            
        }

      

      $font='C:\xampp\htdocs\www.helpus.com\admin\BRUSHSCI.TTF';
      $image=imagecreatefromjpeg("certificate1.jpg");
      $color=imagecolorallocate($image,19,21,22);
   
  
      $size = 180;
  
      $box = imagettfbbox($size, 0, $font, $f_name." ".$l_name);
      $text_width = abs($box[2]) - abs($box[0]);
      $text_height = abs($box[5]) - abs($box[3]);
      $image_width = imagesx($image);
      $image_height = imagesy($image);
      $x = ($image_width - $text_width) / 2;
      $y = ($image_height + $text_height) / 2;
      $z = $x + 250;
  
  
      imagettftext($image,$size,0,$z,$y,$color,$font,$f_name." ".$l_name);
      
      $file="certificate".time();
      $file_path="certificate/".$file.".jpg";
      $file_path_pdf="certificate/".$file.".pdf";
      imagejpeg($image,$file_path);
      imagedestroy($image);
  
      require('fpdf.php');
      $pdf=new FPDF();
      $pdf->AddPage();
      $pdf->Image($file_path,0,0,210,150);
      $pdf->Output($file_path_pdf,"F"); 

      $mail = new PHPMailer();

	$mail->isSMTP();

	$mail->Host = "smtp.gmail.com";

	$mail->SMTPAuth = true;

	$mail->SMTPSecure = "tls";

	$mail->Port = "587";

	$mail->Username = "savelifefoundationsl2@gmail.com";



	$mail->Password = "ywwelcmgxovhzxbp";

//Email subject
$mail->Subject = "Save Life Foundation";
//Set sender email
	$mail->setFrom('savelifefoundationsl2@gmail.com');
//Enable HTML
	$mail->isHTML(true);
//Attachment
	$mail->addAttachment($file_path_pdf);
//Email body
$mail->Body = "Thanks for your donation";
//Add recipient
	$mail->addAddress($email);
//Finally send email
	if ( $mail->send() ) {
        echo "Message sent.  ";
	}else{
		echo "Message could not be sent. Mailer Error: ";
	}
//Closing smtp connection
	$mail->smtpClose();

  }
?>

<?php
include('footer.php');
?>