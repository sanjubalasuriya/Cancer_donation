<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';
require_once __DIR__ . '/../helpers/id_generator.php';

$m_id = generate_next_id($con, 'sponsors', 's_id', 'S');
$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sregister'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $s_id = generate_next_id($con, 'sponsors', 's_id', 'S');
        $f_name = clean_input($_POST['f_name'] ?? '');
        $l_name = clean_input($_POST['l_name'] ?? '');
        $contact = clean_input($_POST['contact'] ?? '');
        $email = clean_input($_POST['email'] ?? '');
        $company = clean_input($_POST['company'] ?? '');

        if ($f_name === '' || $l_name === '' || $contact === '' || $email === '' || $company === '') {
            $errorMsg = 'Please fill in all required fields.';
        } elseif (!is_valid_phone($contact)) {
            $errorMsg = 'Phone number must be exactly 10 digits.';
        } elseif (!is_valid_email($email)) {
            $errorMsg = 'Please enter a valid email address.';
        } else {
            $upload = handle_image_upload($_FILES['simage'] ?? [], __DIR__ . '/../images', 'images', true);
            if (!$upload['ok']) {
                $errorMsg = $upload['error'];
            } else {
                $imgPath = $upload['path'];
                $stmt = mysqli_prepare($con, 'INSERT INTO `sponsors` (`s_id`, `f_name`, `l_name`, `email`, `contact`, `company`, `image`) VALUES (?, ?, ?, ?, ?, ?, ?)');
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'sssssss', $s_id, $f_name, $l_name, $email, $contact, $company, $imgPath);
                    if (mysqli_stmt_execute($stmt)) {
                        $successMsg = 'Sponsor ' . $company . ' (' . $s_id . ') registered successfully.';
                        $m_id = generate_next_id($con, 'sponsors', 's_id', 'S');
                    } else {
                        $errorMsg = 'Failed to register sponsor.';
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
}

include __DIR__ . '/header.php';
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Sponsor Registration</h1>
        <a href="sponsors.php" class="btn btn-secondary">Back to Sponsors</a>
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
                    <label class="labels" for="m_id">Sponsor ID</label>
                    <input type="text" id="m_id" name="m_id" value="<?php echo e($m_id); ?>" readonly>
                </div>
                <div class="input-box">
                    <label class="labels" for="company">Company Name</label>
                    <input type="text" id="company" name="company" placeholder="Enter company name" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="f_name">Contact First Name</label>
                    <input type="text" id="f_name" name="f_name" placeholder="First name" onkeyup="lettersOnly(this)" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="l_name">Contact Last Name</label>
                    <input type="text" id="l_name" name="l_name" placeholder="Last name" onkeyup="lettersOnly(this)" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="contact">Phone Number (10 digits)</label>
                    <input type="tel" id="contact" name="contact" placeholder="07XXXXXXXX" maxlength="10" pattern="[0-9]{10}" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="sponsor@company.com" required>
                </div>
                <div class="input-box full">
                    <label class="labels" for="simage">Company Logo</label>
                    <input type="file" id="simage" name="simage" accept="image/*" required>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="sregister" id="sregister">Register Sponsor</button>
                <a href="sponsors.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
=======
include('header.php');
include ('../db/db.php');


$sql_id = "SELECT * FROM `sponsors` order by id desc limit 1";
$res = mysqli_query($con, $sql_id);
 $row = mysqli_fetch_array($res);
 $lastid = $row['s_id'];

 if($lastid == " "){
   $m_id = "S1";
 }else{
   $m_id = substr($lastid,1);
   $m_id = intval($m_id);
   $m_id = "S" . ($m_id + 1);
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
        Sponsor added Successfully!
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">ID</label>
                        <input type="text" placeholder="Enter First name" required name="m_id"
                            value="<?php echo $m_id;?>" readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels">First Name</label>
                        <input type="text" placeholder="Enter First name" required name="f_name"
                            onkeyup="lettersOnly(this)" required>
                    </div>
                    <div class="input-box">
                        <label class="labels">Last Name</label>
                        <input type="text" placeholder="Enter Last Name" name="l_name" onkeyup="lettersOnly(this)"
                            required>
                    </div>
                    <div class="input-box">
                        <label class="labels">Phone Number</label>
                        <input type="number" placeholder="Enter Patient number" name="contact" required>
                    </div>
                    <div class="input-box">
                        <label class="labels">Email</label>
                        <input type="email" placeholder="Enter Patient Email" name="email" required>
                    </div>
                    <div class="input-box">
                        <label class="labels">Company</label>
                        <input type="text" placeholder="Enter Company Name" name="company" required>
                    </div>
                    <div class="input-box">
                        <label class="labels">Images</label>
                        <input type="file" placeholder="Enter Patient password" name="simage" required>
                    </div>

                </div>

                <div class="button">

                    <input type="submit" class="btn" value="Register" name="sregister" id="sregister">
                    <a href="sponsors.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>


</div>

<?php 



if(isset($_POST["sregister"])){



$m_id = $_POST["m_id"];
$f_name = $_POST["f_name"];
$l_name = $_POST["l_name"];
$contact = $_POST["contact"];
$email = $_POST["email"];
$company = $_POST["company"];



$tm=md5 (time());
$image=$_FILES["simage"]["name"];
$dst="../images/".$tm.$image;
$dst1="images/".$tm.$image;

move_uploaded_file($_FILES["simage"]["tmp_name"],$dst);




$sql = "INSERT INTO `sponsors` (`id`, `s_id`, `f_name`, `l_name`, `email`, `contact`, `company`,  `image`) 
VALUES (NULL, '$m_id', '$f_name', '$l_name', '$email', '$contact', '$company', '$dst1')";

$run_query = mysqli_query($con,$sql);




if($run_query){

    

    
            
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

?>


<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
