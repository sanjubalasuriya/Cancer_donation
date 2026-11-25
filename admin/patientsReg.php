<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';
require_once __DIR__ . '/../helpers/id_generator.php';

$m_id = generate_next_id($con, 'patients', 'p_id', 'P');
$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pregister'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $p_id = generate_next_id($con, 'patients', 'p_id', 'P');
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
        } elseif (!is_valid_nic($nic)) {
            $errorMsg = 'Please enter a valid NIC number.';
        } elseif (!is_valid_phone($contact)) {
            $errorMsg = 'Mobile number must be exactly 10 digits.';
        } elseif (!is_valid_email($email)) {
            $errorMsg = 'Please enter a valid email address.';
        } elseif (!is_positive_number($amountRaw)) {
            $errorMsg = 'Target amount must be greater than zero.';
        } else {
            $upload = handle_image_upload($_FILES['pimage'] ?? [], __DIR__ . '/../image', 'image', true);
            if (!$upload['ok']) {
                $errorMsg = $upload['error'];
            } else {
                $amount = (int)$amountRaw;
                $donateZero = 0;
                $imgPath = $upload['path'];

                $stmt = mysqli_prepare(
                    $con,
                    'INSERT INTO `patients` (`p_id`, `f_name`, `l_name`, `nic`, `contact`, `email`, `dob`, `gender`, `cancer`, `c_step`, `amount`, `donate`, `address`, `image`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'ssssssssssiiss', $p_id, $f_name, $l_name, $nic, $contact, $email, $dob, $gender, $cancer, $c_step, $amount, $donateZero, $address, $imgPath);
                    if (mysqli_stmt_execute($stmt)) {
                        $successMsg = 'Patient ' . $p_id . ' registered successfully.';
                        $m_id = generate_next_id($con, 'patients', 'p_id', 'P');
                    } else {
                        $errorMsg = 'Could not register patient. Please try again.';
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $errorMsg = 'Unable to prepare patient registration query.';
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
=======
include('header.php');
include('../db/db.php');
?>

<!-- <script src="../db/main.js"></script> -->

<?php 

$sql_id = "SELECT * FROM `patients` order by id desc limit 1";
$res = mysqli_query($con, $sql_id);
 $row = mysqli_fetch_array($res);
 $lastid = $row['p_id'];

 if($lastid == " "){
   $m_id = "P1";
 }else{
   $m_id = substr($lastid,1);
   $m_id = intval($m_id);
   $m_id = "P" . ($m_id + 1);
 }


>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
?>

<div class="container_admin">
    <div class="table_title">
<<<<<<< HEAD
        <h1>Patient Registration</h1>
        <a href="patients.php" class="btn btn-secondary">Back to Patients</a>
    </div>
    <hr>

    <?php if ($errorMsg !== ''): ?>
        <div class="alert alert-danger" role="alert"><?php echo e($errorMsg); ?></div>
    <?php endif; ?>
    <?php if ($successMsg !== ''): ?>
        <div class="alert alert-success" role="alert"><?php echo e($successMsg); ?></div>
    <?php endif; ?>

    <div class="content_form">
        <form method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="input-details">
                <div class="input-box">
                    <label class="labels" for="p_id">Patient ID</label>
                    <input type="text" id="p_id" name="p_id" value="<?php echo e($m_id); ?>" readonly>
                </div>
                <div class="input-box">
                    <label class="labels" for="f_name">First Name</label>
                    <input type="text" id="f_name" name="f_name" placeholder="Enter first name" onkeyup="lettersOnly(this)" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="l_name">Last Name</label>
                    <input type="text" id="l_name" name="l_name" placeholder="Enter last name" onkeyup="lettersOnly(this)" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="nic">NIC</label>
                    <input type="text" id="nic" name="nic" placeholder="e.g. 901711671V" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="contact">Phone Number (10 digits)</label>
                    <input type="tel" id="contact" name="contact" placeholder="07XXXXXXXX" maxlength="10" pattern="[0-9]{10}" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="patient@example.com" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" max="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select gender...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="input-box">
                    <label class="labels" for="cancer">Cancer Type</label>
                    <select id="cancer" name="cancer" required>
                        <option value="">Select cancer type...</option>
                        <?php foreach ($cancerOptions as $cname): ?>
                            <option value="<?php echo e($cname); ?>"><?php echo e($cname); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-box">
                    <label class="labels" for="c_step">Cancer Stage</label>
                    <select id="c_step" name="c_step" required>
                        <option value="">Select stage...</option>
                        <option value="Level 1">Level 1</option>
                        <option value="Level 2">Level 2</option>
                        <option value="Level 3">Level 3</option>
                        <option value="Level 4">Level 4</option>
                    </select>
                </div>
                <div class="input-box">
                    <label class="labels" for="amount">Target Amount (Rs.)</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter required treatment amount" min="1" step="1" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="pimage">Patient Photo</label>
                    <input type="file" id="pimage" name="pimage" accept="image/*" required>
                </div>
                <div class="input-box full">
                    <label class="labels" for="address">Address</label>
                    <textarea id="address" name="address" rows="3" placeholder="Enter patient address" required></textarea>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="pregister" id="pregister">Register Patient</button>
                <a href="patients.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
=======
        <h1>Patient Register</h1>


    </div>
    <hr>
    <div class="" id="psign">

    </div>
    <div class="col-md-12 alert alert-success" id="success" style="display:none">
        Patient added Successfully!
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">ID</label>
                        <input type="text" placeholder="Enter First name" required name="p_id" readonly
                            value="<?php echo $m_id;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">First Name</label>
                        <input type="text" placeholder="Enter First name" required name="f_name"
                            onkeyup="lettersOnly(this)">
                    </div>
                    <div class="input-box">
                        <label class="labels">Last Name</label>
                        <input type="text" placeholder="Enter Last username" required name="l_name"
                            onkeyup="lettersOnly(this)">
                    </div>
                    <div class="input-box">
                        <label class="labels">NIC</label>
                        <input type="text" placeholder="Enter Patient NIC" required name="nic">
                    </div>
                    <div class="input-box">
                        <label class="labels">Phone Number</label>
                        <input type="number" placeholder="Enter Patient number" required name="contact">
                    </div>
                    <div class="input-box">
                        <label class="labels">Email</label>
                        <input type="email" placeholder="Enter Patient Email" required name="email">
                    </div>
                    <div class="input-box">
                        <label class="labels">Date Of Birth</label>
                        <input type="date" placeholder="Enter Patient Date of Birth" required name="dob">
                    </div>
                    <div class="input-box">
                        <label class="labels">Gender</label>
                        <select name="gender" id="">
                            <option value="">Select</option>
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
                        <select name="cancer" id="">
                            <option value="">Select</option>
                            <?php while($rows = mysqli_fetch_array($res)){
                            ?>
                            <option value="<?php echo $rows['name']; ?>"><?php echo $rows['name'] ?></option>
                            <?php

                            }?>
                        </select>
                    </div>

                    <div class="input-box">
                        <label class="labels">Patients Cancer Step</label>
                        <select name="c_step" id="">
                            <option value="">Select</option>
                            <option value="Level 1">Level 1</option>
                            <option value="Level 2">Level 2</option>
                            <option value="Level 3">Level 3</option>
                            <option value="Level 4">Level 4</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label class="labels">Amount</label>
                        <input type="number" placeholder="Enter Patient Amount" required name="amount">
                    </div>
                    <div class="input-box">
                        <label class="labels">Address</label>
                        <!-- <input type="text" placeholder="Enter Patient Address" required name="address"> -->
                        <textarea name="address" id="" rows="10" type="text" required></textarea>
                    </div>
                    <div class="input-box">
                        <label class="labels">Images</label>
                        <input type="file" placeholder="Enter Patient password" required name="pimage">
                    </div>
                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Register" name="pregister" id="pregister">
                    <a href="patients.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>


<?php

if(isset($_POST["pregister"])){

    $p_id = $_POST["p_id"];
    $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $nic = $_POST["nic"];
    $contact = $_POST["contact"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $cancer = $_POST["cancer"];
    $c_step = $_POST["c_step"];
    $amount = $_POST["amount"];
    $address = $_POST["address"];

    $tm=md5 (time());
    $image=$_FILES["pimage"]["name"];
    $dst="../image/".$tm.$image;
    $dst1="image/".$tm.$image;

    move_uploaded_file($_FILES["pimage"]["tmp_name"],$dst);

    $emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
    
    


    if(empty($f_name) || empty($l_name) || empty($nic) || empty($contact) || empty($email) || empty($dob) 
    || empty($gender) || empty($cancer) || empty($c_step) || empty($amount) || empty($address) || empty($image) ){


        echo "
                <div class=' alert-warning' role='alert'>
                    <b>  Fill All Fields...</b>
                </div>
    
        ";
        exit();
    }

    if(!preg_match($emailValidation,$email)){
        echo "
        <div class=' alert-warning' role='alert'>
            <b> This email ' $email ' is not valid...!</b>
        </div>
        
        ";
        exit();
    }

    if(!(strlen($contact) == 10)){
        echo "
        <div class='alert alert-warning' role='alert'>
            <b>  Mobile number should be 10 digit...!</b>
        </div>
        
        ";
        exit();
    }
    else{

            $sql = "INSERT INTO `patients`(`p_id`, `f_name`, `l_name`, `nic`, `contact`, `email`, `dob`, `gender`, `cancer`, `c_step`, `amount`, `address`, `image`) VALUES 
            ('$p_id','$f_name','$l_name','$nic','$contact','$email','$dob','$gender','$cancer','$c_step','$amount','$address', '$dst1')";
            $result = mysqli_query($con,$sql);
            
            if($result){

            

            ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location.href = window.location.href;
}, 2000);
</script>

<?php
}
        
    }


}


include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
