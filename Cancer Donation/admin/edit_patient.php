<?php
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