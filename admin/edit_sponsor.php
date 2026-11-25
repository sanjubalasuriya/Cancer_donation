<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$sponsor = null;

if ($id && $id > 0) {
    $stmt = mysqli_prepare($con, 'SELECT * FROM `sponsors` WHERE `id` = ? LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $sponsor = $res ? mysqli_fetch_assoc($res) : null;
        mysqli_stmt_close($stmt);
    }
}

$errorMsg = '';
$successMsg = '';

if ($sponsor && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supdate'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $f_name = clean_input($_POST['f_name'] ?? '');
        $l_name = clean_input($_POST['l_name'] ?? '');
        $email = clean_input($_POST['email'] ?? '');
        $contact = clean_input($_POST['contact'] ?? '');
        $company = clean_input($_POST['company'] ?? '');

        if ($f_name === '' || $l_name === '' || $email === '' || $contact === '' || $company === '') {
            $errorMsg = 'Please fill in all required fields.';
        } elseif (!is_valid_phone($contact)) {
            $errorMsg = 'Phone number must be exactly 10 digits.';
        } elseif (!is_valid_email($email)) {
            $errorMsg = 'Please enter a valid email address.';
        } else {
            $upload = handle_image_upload($_FILES['pimage'] ?? [], __DIR__ . '/../images', 'images', false);
            if (!$upload['ok']) {
                $errorMsg = $upload['error'];
            } else {
                $newImg = $upload['path'] ?: $sponsor['image'];
                $upd = mysqli_prepare($con, 'UPDATE `sponsors` SET `f_name` = ?, `l_name` = ?, `email` = ?, `contact` = ?, `company` = ?, `image` = ? WHERE `id` = ?');
                if ($upd) {
                    mysqli_stmt_bind_param($upd, 'ssssssi', $f_name, $l_name, $email, $contact, $company, $newImg, $id);
                    if (mysqli_stmt_execute($upd)) {
                        $successMsg = 'Sponsor updated successfully.';
                        $sponsor = array_merge($sponsor, [
                            'f_name' => $f_name,
                            'l_name' => $l_name,
                            'email' => $email,
                            'contact' => $contact,
                            'company' => $company,
                            'image' => $newImg,
                        ]);
                    } else {
                        $errorMsg = 'Failed to update sponsor.';
                    }
                    mysqli_stmt_close($upd);
                }
            }
        }
    }
}

include __DIR__ . '/header.php';
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Edit Sponsor</h1>
        <a href="sponsors.php" class="btn btn-secondary">Back to Sponsors</a>
    </div>
    <hr>

    <?php if (!$sponsor): ?>
        <div class="empty-state">
            <h3>Sponsor Not Found</h3>
            <p>The requested sponsor record does not exist.</p>
            <a href="sponsors.php" class="btn">Return to Sponsors</a>
        </div>
    <?php else: ?>
        <?php if ($errorMsg !== ''): ?>
            <div class="alert alert-danger" role="alert"><?php echo e($errorMsg); ?></div>
        <?php endif; ?>
        <?php if ($successMsg !== ''): ?>
            <div class="alert alert-success" role="alert"><?php echo e($successMsg); ?></div>
        <?php endif; ?>

        <img class="preview-avatar" src="../<?php echo e($sponsor['image'] ?: 'img/logo.png'); ?>" alt="<?php echo e($sponsor['company']); ?>">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels" for="s_id">Sponsor ID</label>
                        <input type="text" id="s_id" name="s_id" value="<?php echo e($sponsor['s_id']); ?>" readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="company">Company Name</label>
                        <input type="text" id="company" name="company" value="<?php echo e($sponsor['company']); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="f_name">First Name</label>
                        <input type="text" id="f_name" name="f_name" value="<?php echo e($sponsor['f_name']); ?>" onkeyup="lettersOnly(this)" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="l_name">Last Name</label>
                        <input type="text" id="l_name" name="l_name" value="<?php echo e($sponsor['l_name']); ?>" onkeyup="lettersOnly(this)" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="contact">Phone Number</label>
                        <input type="tel" id="contact" name="contact" value="<?php echo e($sponsor['contact']); ?>" maxlength="10" pattern="[0-9]{10}" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo e($sponsor['email']); ?>" required>
                    </div>
                    <div class="input-box full">
                        <label class="labels" for="pimage">Replace Logo (optional)</label>
                        <input type="file" id="pimage" name="pimage" accept="image/*">
=======
include('header.php');
include ('../db/db.php');
?>

<script src="../db/main.js"></script>


<?php

$id=$_GET["id"];
$s_id="";
$f_name="";
$l_name="";
$email="";
$contact="";
$company="";

$img="";



    


$res=mysqli_query($con,"SELECT * FROM `sponsors` WHERE id=$id");  
while($row=mysqli_fetch_array($res))
{
    $s_id=$row["s_id"];
    $f_name=$row["f_name"];
    $l_name=$row["l_name"];
    $contact=$row["contact"];
    $email=$row["email"];
    $company=$row["company"];
    
    $img=$row["image"];
    
    
    
}

?>



<div class="container_admin">
    <div class="table_title">
        <h1>Sponsor Register</h1>

    </div>
    <hr>
    <div class="" id="ssign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Sponsor Updated Successfully!
    </div>

    <div>
        <center><img src="../<?php echo $img; ?>" width="250;" heigth="250;" alt="image"></center>
    </div>

    <div class="">

        <div class="content_form">
            <form method="post" enctype="multipart/form-data">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">ID</label>
                        <input type="text" placeholder="Enter First name" required name="s_id"
                            value="<?php echo $s_id;?>" readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels">First Name</label>
                        <input type="text" placeholder="Enter First name" required name="f_name"
                            value="<?php echo $f_name;?>" onkeyup="lettersOnly(this)">
                    </div>
                    <div class="input-box">
                        <label class="labels">Last Name</label>
                        <input type="text" placeholder="Enter Last Name" required name="l_name"
                            value="<?php echo $l_name;?>" onkeyup="lettersOnly(this)">
                    </div>
                    <div class="input-box">
                        <label class="labels">Phone Number</label>
                        <input type="number" placeholder="Enter Patient number" required name="contact"
                            value="<?php echo $contact;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Email</label>
                        <input type="email" placeholder="Enter Patient Email" required name="email"
                            value="<?php echo $email;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Company</label>
                        <input type="text" placeholder="Enter Company Name" required name="company"
                            value="<?php echo $company;?>">
                    </div>

                    <div class="input-box">
                        <label class="labels">Images</label>
                        <input type="file" placeholder="Enter  Image" name="pimage" value="<?php echo $img;?>">
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
                    </div>
                </div>

                <div class="button">
<<<<<<< HEAD
                    <button type="submit" class="btn" name="supdate" id="supdate">Save Changes</button>
                    <a href="sponsors.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
=======
                    <button type="submit" class="btn" name="supdate" id="supdate">Update</button>
                </div>
            </form>
        </div>

    </div>


</div>

<?php
if(isset($_POST["supdate"]))

{

    $tm=md5 (time());
    $image=$_FILES["pimage"]["name"];
    $dst="../image/".$tm.$image;
    $dst1="image/".$tm.$image;

    move_uploaded_file($_FILES["pimage"]["tmp_name"],$dst);

    if(empty($image) ){
        
        
        mysqli_query($con,"UPDATE `sponsors` SET s_id='$_POST[s_id]', f_name='$_POST[f_name]', l_name='$_POST[l_name]', email='$_POST[email]',
     contact='$_POST[contact]', company='$_POST[company]' WHERE id=$id") or die(mysqli_error($con)); 
     
     ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "sponsors.php";
}, 1000);
</script>
<?php

exit();
    }

else{



    mysqli_query($con,"UPDATE `sponsors` SET s_id='$_POST[s_id]', f_name='$_POST[f_name]', l_name='$_POST[l_name]', email='$_POST[email]', contact='$_POST[contact]',
     company='$_POST[company]', image='$dst1' WHERE id=$id") or die(mysqli_error($con));  

    ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "sponsors.php";
}, 1000);
</script>
<?php

}
 }



?>




<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
