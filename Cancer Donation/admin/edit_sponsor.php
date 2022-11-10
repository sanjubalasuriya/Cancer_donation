<?php
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
                    </div>
                </div>

                <div class="button">
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