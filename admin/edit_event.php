<?php
include('header.php');
include ('../db/db.php');



$id=$_GET["id"];
$title="";
$image="";
$location="";

$description="";
$date="";



$res=mysqli_query($con,"SELECT * FROM `event` WHERE id=$id");  
while($row=mysqli_fetch_array($res))
{
    
    $title=$row["title"];
    $image=$row["image"];
    $description=$row["description"];
    $location=$row["location"];
    $date=$row["date"];
    
    
    
}

?>





<div class="container_admin">
    <div class="table_title">
        <h1>Update Event</h1>


    </div>
    <hr>
    <div class="" id="event_sign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Event Updated Successfully!
    </div>
    <div>
        <center><img src="../<?php echo $image; ?>" width="250;" heigth="250;" alt="image"></center>
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">Title</label>
                        <input type="text" placeholder="Enter Title" required name="title" value="<?php echo $title;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Location</label>
                        <input type="text" placeholder="Enter location" required name="location"
                            value="<?php echo $location;?>">
                    </div>

                    <div class="input-box">
                        <label class="labels">Image</label>
                        <input type="file" placeholder="Enter Image" name="eimage" value="<?php echo $image;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Date</label>
                        <input type="date" placeholder="Enter Description" required name="date"
                            value="<?php echo $date;?>">
                    </div>
                    <div class="input-box">

                        <label class="labels">Description</label>

                        <textarea rows="10" required name="description"><?php echo $description;?></textarea>
                    </div>

                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Update" name="event1" id="event">
                    <a href="events.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>

<?php
if(isset($_POST["event1"]))

{

    $tm=md5 (time());
    $image=$_FILES["eimage"]["name"];
    $dst="../imagee/".$tm.$image;
    $dst1="imagee/".$tm.$image;

    move_uploaded_file($_FILES["eimage"]["tmp_name"],$dst);

    if(empty($image) ){
        
        mysqli_query($con,"UPDATE `event` SET title='$_POST[title]', location='$_POST[location]', description='$_POST[description]', date='$_POST[date]'  WHERE id='$id'") or die(mysqli_error($con)); 
     
     ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "events.php";
}, 1000);
</script>
<?php

exit();
    }

else{



    mysqli_query($con,"UPDATE `event` SET title='$_POST[title]', location='$_POST[location]',image='$dst1', description='$_POST[description]', date='$_POST[date]'  WHERE id='$id'") or die(mysqli_error($con)); 

    ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "events.php";
}, 1000);
</script>
<?php

}
 }



?>


<?php
include('footer.php');
?>