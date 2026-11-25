<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$patient = null;

if ($id && $id > 0) {
    $stmt = mysqli_prepare($con, 'SELECT * FROM `patients` WHERE `id` = ? LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $patient = $res ? mysqli_fetch_assoc($res) : null;
        mysqli_stmt_close($stmt);
    }
}

$errorMsg = '';
$successMsg = '';

if ($patient && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pupdate'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $f_name = clean_input($_POST['f_name'] ?? '');
        $l_name = clean_input($_POST['l_name'] ?? '');
        $nic = clean_input($_POST['nic'] ?? '');
        $contact = clean_input($_POST['contact'] ?? '');
        $email = clean_input($_POST['email'] ?? '');
        $dob = clean_input($_POST['dob'] ?? '');
        $gender = clean_input($_POST['gender'] ?? '');
        $cancer = clean_input($_POST['cancer'] ?? '');
        $c_step = clean_input($_POST['c_step'] ?? '');
        $amountRaw = clean_input($_POST['amount'] ?? '');
        $address = clean_input($_POST['address'] ?? '');

        if ($f_name === '' || $l_name === '' || $nic === '' || $contact === '' || $email === '' || $dob === '' || $gender === '' || $cancer === '' || $c_step === '' || $amountRaw === '' || $address === '') {
            $errorMsg = 'Please fill in all required fields.';
        } elseif (!is_valid_phone($contact)) {
            $errorMsg = 'Mobile number must be exactly 10 digits.';
        } elseif (!is_valid_email($email)) {
            $errorMsg = 'Please enter a valid email address.';
        } elseif (!is_positive_number($amountRaw)) {
            $errorMsg = 'Amount must be greater than zero.';
        } else {
            $upload = handle_image_upload($_FILES['pimage'] ?? [], __DIR__ . '/../image', 'image', false);
            if (!$upload['ok']) {
                $errorMsg = $upload['error'];
            } else {
                $amount = (int)$amountRaw;
                $newImg = $upload['path'] ?: $patient['image'];

                $upd = mysqli_prepare(
                    $con,
                    'UPDATE `patients` SET `f_name` = ?, `l_name` = ?, `nic` = ?, `contact` = ?, `email` = ?, `dob` = ?, `gender` = ?, `cancer` = ?, `c_step` = ?, `amount` = ?, `address` = ?, `image` = ? WHERE `id` = ?'
                );
                if ($upd) {
                    mysqli_stmt_bind_param($upd, 'sssssssssissi', $f_name, $l_name, $nic, $contact, $email, $dob, $gender, $cancer, $c_step, $amount, $address, $newImg, $id);
                    if (mysqli_stmt_execute($upd)) {
                        $successMsg = 'Patient record updated successfully.';
                        $patient = array_merge($patient, [
                            'f_name' => $f_name,
                            'l_name' => $l_name,
                            'nic' => $nic,
                            'contact' => $contact,
                            'email' => $email,
                            'dob' => $dob,
                            'gender' => $gender,
                            'cancer' => $cancer,
                            'c_step' => $c_step,
                            'amount' => $amount,
                            'address' => $address,
                            'image' => $newImg,
                        ]);
                    } else {
                        $errorMsg = 'Failed to update patient record.';
                    }
                    mysqli_stmt_close($upd);
                }
            }
        }
    }
}

include __DIR__ . '/header.php';

$cancerOptions = [];
$cRes = mysqli_query($con, 'SELECT `name` FROM `cancers` ORDER BY `name` ASC');
if ($cRes) {
    while ($cRow = mysqli_fetch_assoc($cRes)) {
        $cancerOptions[] = $cRow['name'];
    }
}
$stages = ['Level 1', 'Level 2', 'Level 3', 'Level 4'];
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Edit Patient</h1>
        <a href="patients.php" class="btn btn-secondary">Back to Patients</a>
    </div>
    <hr>

    <?php if (!$patient): ?>
        <div class="empty-state">
            <h3>Patient Not Found</h3>
            <p>The requested patient record does not exist.</p>
            <a href="patients.php" class="btn">Return to Patients</a>
        </div>
    <?php else: ?>
        <?php if ($errorMsg !== ''): ?>
            <div class="alert alert-danger" role="alert"><?php echo e($errorMsg); ?></div>
        <?php endif; ?>
        <?php if ($successMsg !== ''): ?>
            <div class="alert alert-success" role="alert"><?php echo e($successMsg); ?></div>
        <?php endif; ?>

        <img class="preview-avatar" src="../<?php echo e($patient['image'] ?: 'img/patients1.jpg'); ?>" alt="<?php echo e($patient['f_name']); ?>">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels" for="p_id">Patient ID</label>
                        <input type="text" id="p_id" name="p_id" value="<?php echo e($patient['p_id']); ?>" readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="f_name">First Name</label>
                        <input type="text" id="f_name" name="f_name" value="<?php echo e($patient['f_name']); ?>" onkeyup="lettersOnly(this)" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="l_name">Last Name</label>
                        <input type="text" id="l_name" name="l_name" value="<?php echo e($patient['l_name']); ?>" onkeyup="lettersOnly(this)" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="nic">NIC</label>
                        <input type="text" id="nic" name="nic" value="<?php echo e($patient['nic']); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="contact">Phone Number</label>
                        <input type="tel" id="contact" name="contact" value="<?php echo e($patient['contact']); ?>" maxlength="10" pattern="[0-9]{10}" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo e($patient['email']); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?php echo e($patient['dob']); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="Male" <?php echo $patient['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $patient['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="cancer">Cancer Type</label>
                        <select id="cancer" name="cancer" required>
                            <?php foreach ($cancerOptions as $cname): ?>
                                <option value="<?php echo e($cname); ?>" <?php echo $patient['cancer'] === $cname ? 'selected' : ''; ?>><?php echo e($cname); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="c_step">Cancer Stage</label>
                        <select id="c_step" name="c_step" required>
                            <?php foreach ($stages as $stage): ?>
                                <option value="<?php echo e($stage); ?>" <?php echo $patient['c_step'] === $stage ? 'selected' : ''; ?>><?php echo e($stage); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="amount">Target Amount (Rs.)</label>
                        <input type="number" id="amount" name="amount" value="<?php echo e((string)$patient['amount']); ?>" min="1" step="1" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="pimage">Replace Photo (optional)</label>
                        <input type="file" id="pimage" name="pimage" accept="image/*">
                    </div>
                    <div class="input-box full">
                        <label class="labels" for="address">Address</label>
                        <textarea id="address" name="address" rows="3" required><?php echo e($patient['address']); ?></textarea>
                    </div>
                </div>

                <div class="button">
                    <button type="submit" class="btn" name="pupdate" id="pupdate">Save Changes</button>
                    <a href="patients.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
=======
include('header.php');

?>

<script src="../db/main.js"></script>

<?php



$id=$_GET["id"];
$p_id="";
$f_name="";
$l_name="";
$nic="";
$contact="";
$email="";
$dob="";
$gender="";
$cancer="";
$c_step="";
$amount="";
$donate="";
$address="";
$img='';



    


$res=mysqli_query($con,"SELECT * FROM `patients` WHERE id=$id");  
while($row=mysqli_fetch_array($res))
{
    $p_id=$row["p_id"];
    $f_name=$row["f_name"];
    $l_name=$row["l_name"];
    $nic=$row["nic"];
    $contact=$row["contact"];
    $email=$row["email"];
    $dob=$row["dob"];
    $gender=$row["gender"];
    $cancer=$row["cancer"];
    $c_step=$row["c_step"];
    $amount=$row["amount"];
    $donate=$row["donate"];
    $address=$row["address"];
    $img=$row["image"];
    
    
}

?>


<div class="container_admin">
    <div class="table_title">
        <h1>Patient Edit</h1>


    </div>
    <hr>
    <div class="" id="psign">

    </div>
    <div class="col-md-12 alert alert-success" id="success" style="display:none">
        Patient added Successfully!
    </div>

    <div>
        <center><img src="../<?php echo $img; ?>" width="250;" heigth="250;" alt="image"></center>
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">Patient ID</label>
                        <input type="text" placeholder="Enter First name" required name="p_id" readonly
                            value="<?php echo $p_id;?>" onkeyup="lettersOnly(this)">
                    </div>
                    <div class="input-box">
                        <label class="labels">First Name</label>
                        <input type="text" placeholder="Enter First name" required name="f_name"
                            value="<?php echo $f_name;?>" onkeyup="lettersOnly(this)">
                    </div>
                    <div class="input-box">
                        <label class="labels">Last Name</label>
                        <input type="text" placeholder="Enter Last username" required name="l_name"
                            value="<?php echo $l_name;?>" onkeyup="lettersOnly(this)">
                    </div>
                    <div class="input-box">
                        <label class="labels">NIC</label>
                        <input type="text" placeholder="Enter Patient NIC" required name="nic"
                            value="<?php echo $nic;?>">
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
                        <label class="labels">Date Of Birth</label>
                        <input type="date" placeholder="Enter Patient Date of Birth" required name="dob"
                            value="<?php echo $dob;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Gender</label>
                        <select name="gender" id="" value="<?php echo $gender;?>">

                            <option value="<?php echo $gender;?>"><?php echo $gender;?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <?php 
                
                $sql = "SELECT * FROM `cancers` ";
                $res = mysqli_query($con, $sql);
            
                ?>

                    <div class="input-box">
                        <label class="labels">Cancer</label>

                        <select name="cancer" id="" value="<?php echo $rows['name']; ?>">
                            <option value="<?php echo $cancer;?>"><?php echo $cancer;?></option>
                            <?php while($rows = mysqli_fetch_array($res)){
                            ?>
                            <option value="<?php echo $rows['name']; ?>"><?php echo $rows['name'] ?></option>
                            <?php

                            }?>
                        </select>
                    </div>
                    <div class="input-box">
                        <label class="labels">Patients Cancer Step</label>

                        <select name="c_step" id="" value="<?php echo $rows['c_step']; ?>">
                            <option value=""><?php echo $c_step;?></option>
                            <option value="Level 1">Level 1</option>
                            <option value="Level 2">Level 2</option>
                            <option value="Level 3">Level 3</option>
                            <option value="Level 4">Level 4</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label class="labels">Amount</label>
                        <input type="number" placeholder="Enter Patient Amount" required name="amount"
                            value="<?php echo $amount;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Images</label>
                        <input type="file" placeholder="Enter Patient Image" name="pimage" value="<?php echo $img;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Address</label>


                        <textarea name="address" id="" rows="10"><?php echo $address;?></textarea>
                    </div>


                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Update" name="pupdate" id="pupdate">
                    <a href="patients.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>


<?php
if(isset($_POST["pupdate"]))

{

    $tm=md5 (time());
    $image=$_FILES["pimage"]["name"];
    $dst="../image/".$tm.$image;
    $dst1="image/".$tm.$image;

    move_uploaded_file($_FILES["pimage"]["tmp_name"],$dst);

    if(empty($image) ){


        mysqli_query($con,"UPDATE `patients` SET f_name='$_POST[f_name]', l_name='$_POST[l_name]', nic='$_POST[nic]', contact='$_POST[contact]', email='$_POST[email]', dob='$_POST[dob]', 
        cancer='$_POST[cancer]', c_step='$_POST[c_step]', amount='$_POST[amount]', address='$_POST[address]' WHERE id=$id") or die(mysqli_error($con));  



?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "patients.php";
}, 2000);
</script>
<?php


        exit();
    }
    
    else{


    mysqli_query($con,"UPDATE `patients` SET f_name='$_POST[f_name]', l_name='$_POST[l_name]', nic='$_POST[nic]', contact='$_POST[contact]', email='$_POST[email]', dob='$_POST[dob]', 
    cancer='$_POST[cancer]', c_step='$_POST[c_step]', amount='$_POST[amount]', address='$_POST[address]', image='$dst1' WHERE id=$id") or die(mysqli_error($con));  

    ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "patients.php";
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
