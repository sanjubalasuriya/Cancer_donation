<?php
include('header.php');
include ('../db/db.php');
?>



<?php

$id=$_GET["id"];
$num="";
$name="";




    


$res=mysqli_query($con,"SELECT * FROM `cancers` WHERE id=$id");  
while($row=mysqli_fetch_array($res))
{
    
    $num=$row["num"];
    $name=$row["name"];
    
    
    
}

?>

<div class="container_admin">
    <div class="table_title">
        <h1>Cancer Update</h1>


    </div>
    <hr>
    <div class="" id="csign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Cancer Updated Successfully!
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">ID</label>
                        <input type="text" placeholder="Enter First name" required name="num" readonly
                            value="<?php echo $num;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Cancer Name</label>
                        <input type="text" placeholder="Enter Last username" required name="name"
                            value="<?php echo $name;?>">
                    </div>

                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Update" name="cupdate" id="cupdate">
                    <a href="cancers.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>


<?php
if(isset($_POST["cupdate"]))

{
    mysqli_query($con,"UPDATE `cancers` SET num='$_POST[num]', name='$_POST[name]' WHERE id=$id") or die(mysqli_error($con));  

    ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "cancers.php";
}, 1000);
</script>
<?php
 }



?>


<?php
include('footer.php');
?>