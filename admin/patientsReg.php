<?php
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


?>

<div class="container_admin">
    <div class="table_title">
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