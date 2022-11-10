<?php
include('header.php');
include ('../db/db.php');
?>

<script src="../db/main.js"></script>

<?php



$id=$_GET["id"];
$name="";
$address="";
$lat="";
$lng="";
$s_id="";
$email="";
$lisence="";
$contact="";





    


$res=mysqli_query($con,"SELECT * FROM `salons` WHERE id=$id");  
while($row=mysqli_fetch_array($res))
{
    
    $name=$row["name"];
    $address=$row["address"];
    $lat=$row["lat"];
    $lng=$row["lng"];
    $s_id=$row["s_id"];
    $email=$row["email"];
    $lisence=$row["lisence"];
    $contact=$row["contact"];
  
}

?>

<div class="container_admin">
    <div class="table_title">
        <h1>Add Salon</h1>
        <form method="post"><button class="btn" name="reset" type="submit">Reset Password</button></form>

    </div>
    <hr>
    <div class="" id="salon_sign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Salon edited Successfully!
    </div>
    <div class="alert-success" id="success1" style="display:none">
        Password reset Successfull!
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">ID</label>
                        <input type="text" placeholder="Enter Name" required name="s_id" value="<?php echo $s_id ?>"
                            readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels">Name</label>
                        <input type="text" placeholder="Enter Name" required name="name" value="<?php echo $name;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Email</label>
                        <input type="email" placeholder="Enter Email" required name="email"
                            value="<?php echo $email;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Lisence No</label>
                        <input type="text" placeholder="Enter Lisence No" required name="lisence"
                            value="<?php echo $lisence;?>">
                    </div>


                    <div class="input-box">
                        <label class="labels">Latitude</label>
                        <input type="text" placeholder="Enter Latitude" required name="lat" value="<?php echo $lat;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Longtude</label>
                        <input type="text" placeholder="Enter Longtude" required name="lng" value="<?php echo $lng;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Contact</label>
                        <input type="number" placeholder="Enter Mobile Number" required name="contact"
                            value="<?php echo $contact;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Address</label>
                        <textarea name="address" id="" rows="10" type="text" required
                            placeholder="Enter Address"><?php echo $address;?></textarea>
                    </div>

                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Edit" name="editsalon" id="editsalon">
                </div>
            </form>
        </div>

    </div>



</div>

<?php
if(isset($_POST["editsalon"]))

{
    mysqli_query($con,"UPDATE `salons` SET name='$_POST[name]',  address='$_POST[address]', lat='$_POST[lat]', lng='$_POST[lng]', email='$_POST[email]', lisence='$_POST[lisence]',contact='$_POST[contact]' WHERE id=$id") or die(mysqli_error($con));  

    ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "salons.php";
}, 1000);
</script>
<?php
 }

?>

<?php
if(isset($_POST["reset"]))

{




    mysqli_query($con,"UPDATE `login` SET password=md5('123456') WHERE uname='$s_id'") or die(mysqli_error($con));  

    ?>
<script type="text/javascript">
document.getElementById("success1").style.display = "block";
setTimeout(function() {
    window.location = "salons.php";
}, 1000);
</script>
<?php
 }

?>


<?php
include('footer.php');
?>