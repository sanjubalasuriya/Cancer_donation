<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/mailer.php';
require_once __DIR__ . '/../helpers/response.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_btn_set'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        json_response(false, 'Session expired. Please refresh and try again.', [], 403);
    }

    $reqId = filter_var($_POST['delete_id'] ?? null, FILTER_VALIDATE_INT);
    if (!$reqId || $reqId <= 0) {
        json_response(false, 'Invalid hair donation request ID.', [], 400);
    }

    $stmt = mysqli_prepare($con, 'SELECT `id`, `f_name`, `l_name`, `email`, `request` FROM `organ` WHERE `id` = ? LIMIT 1');
    if (!$stmt) {
        json_response(false, 'Unable to load hair donation request.', [], 500);
    }
    mysqli_stmt_bind_param($stmt, 'i', $reqId);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $donor = $res ? mysqli_fetch_assoc($res) : null;
    mysqli_stmt_close($stmt);

    if (!$donor) {
        json_response(false, 'Hair donation request not found.', [], 404);
    }

    $fullName = trim($donor['f_name'] . ' ' . $donor['l_name']);
    $fontPath = __DIR__ . '/BRUSHSCI.TTF';
    $templatePath = __DIR__ . '/Certificate1.jpg';
    $certDir = __DIR__ . '/certificate';

    if (!is_dir($certDir) && !mkdir($certDir, 0755, true)) {
        json_response(false, 'Failed to prepare certificate output folder.', [], 500);
    }

    if (!is_file($templatePath) || !is_file($fontPath)) {
        json_response(false, 'Certificate template or font file is missing on the server.', [], 500);
    }

    if (!function_exists('imagecreatefromjpeg') || !function_exists('imagettftext')) {
        json_response(false, 'PHP GD with FreeType support is required to generate certificates.', [], 500);
    }

    $image = @imagecreatefromjpeg($templatePath);
    if (!$image) {
        json_response(false, 'Could not load certificate template image.', [], 500);
    }

    $color = imagecolorallocate($image, 19, 21, 22);
    $size = 180;
    $box = imagettfbbox($size, 0, $fontPath, $fullName);
    $textWidth = abs($box[2] - $box[0]);
    $textHeight = abs($box[5] - $box[3]);
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);
    $x = (int)(($imageWidth - $textWidth) / 2) + 250;
    $y = (int)(($imageHeight + $textHeight) / 2);

    imagettftext($image, $size, 0, $x, $y, $color, $fontPath, $fullName);

    $baseName = 'certificate_' . $reqId . '_' . time();
    $jpgPath = $certDir . DIRECTORY_SEPARATOR . $baseName . '.jpg';
    $pdfPath = $certDir . DIRECTORY_SEPARATOR . $baseName . '.pdf';

    imagejpeg($image, $jpgPath, 92);
    imagedestroy($image);

    require_once __DIR__ . '/fpdf.php';
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->Image($jpgPath, 0, 0, 210, 150);
    $pdf->Output($pdfPath, 'F');

    $bodyHtml = '<p>Thank you for your inspiring hair donation to Save Life Cancer Foundation.</p>'
        . '<p>Please find your official Certificate of Appreciation attached to this email.</p>';
    $htmlBody = build_foundation_email($fullName, 'Certificate of Appreciation', $bodyHtml);
    $mailResult = send_foundation_email($donor['email'], 'Save Life Foundation - Appreciation Certificate', $htmlBody, $pdfPath);

    $upd = mysqli_prepare($con, "UPDATE `organ` SET `request` = 'sent' WHERE `id` = ?");
    if ($upd) {
        mysqli_stmt_bind_param($upd, 'i', $reqId);
        mysqli_stmt_execute($upd);
        mysqli_stmt_close($upd);
    }

    $msg = $mailResult['sent']
        ? 'Certificate generated and emailed to ' . $donor['email'] . '.'
        : 'Certificate PDF generated and marked as sent (email delivery failed: ' . ($mailResult['error'] ?? 'SMTP unavailable') . ').';

    json_response(true, $msg, ['email_sent' => $mailResult['sent']]);
}

include __DIR__ . '/header.php';

$requests = [];
$res = mysqli_query($con, 'SELECT `id`, `salon_id`, `f_name`, `l_name`, `email`, `nic`, `request`, `date` FROM `organ` ORDER BY (`request` = "pending") DESC, `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $requests[] = $row;
    }
}
$csrf = csrf_token();
=======
include('header.php');






require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
?>

<div class="container_admin">
    <div class="table_title">
<<<<<<< HEAD
        <h1>Hair Donation Requests</h1>
    </div>
    <hr>

    <?php if (empty($requests)): ?>
        <div class="empty-state">
            <h3>No Hair Donation Requests</h3>
            <p>Requests submitted by partner salons will appear here for certificate generation.</p>
        </div>
    <?php else: ?>
        <div class="details_table">
=======
        <h1>Hair Donate request List</h1>


    </div>
    <hr>

    <div class="container_body">
        <div class="details_table">


>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
<<<<<<< HEAD
                        <th>Salon</th>
                        <th>Donor Name</th>
                        <th>Email</th>
                        <th>NIC</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $row): ?>
                        <tr>
                            <td>#<?php echo (int)$row['id']; ?></td>
                            <td><strong><?php echo e($row['salon_id']); ?></strong></td>
                            <td><?php echo e($row['f_name'] . ' ' . $row['l_name']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td><?php echo e($row['nic']); ?></td>
                            <td>
                                <span class="badge <?php echo $row['request'] === 'sent' ? 'badge-success' : 'badge-warning'; ?>">
                                    <?php echo e($row['request']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($row['request'] === 'pending'): ?>
                                    <button type="button"
                                            class="action edit js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Send Certificate?"
                                            data-text="Generate and email PDF certificate to <?php echo e($row['email']); ?>?"
                                            data-confirm-text="Send PDF">
                                        Send Certificate
                                    </button>
                                <?php else: ?>
                                    <button type="button"
                                            class="action secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Resend Certificate?"
                                            data-text="Regenerate and resend PDF certificate to <?php echo e($row['email']); ?>?"
                                            data-confirm-text="Resend">
                                        Resend
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
=======
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
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
