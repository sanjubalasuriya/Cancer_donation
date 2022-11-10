<?php
include('header.php');
include ('../db/db.php');


$id=$_GET["id"];
$title="";
$image="";
$description="";



$res=mysqli_query($con,"SELECT * FROM `news` WHERE id=$id");  
while($row=mysqli_fetch_array($res))
{
    
    $title=$row["title"];
    $image=$row["image"];
    $description=$row["description"];
    
    
    
}


?>





<div class="container_admin">
    <div class="table_title">
        <h1>Update News</h1>


    </div>
    <hr>
    <div class="" id="news_sign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        News Updated Successfully!
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
                        <label class="labels">Image</label>
                        <input type="file" placeholder="Enter Image" name="nimage" value="<?php echo $image;?>">
                    </div>

                    <div class="input-box">
                        <label class="labels">Description</label>

                        <textarea type="text" placeholder="Enter Description" required name="description"
                            rows="10"><?php echo $description;?></textarea>
                    </div>


                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Update" name="news" id="news">
                    <a href="newss.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>

<?php
if(isset($_POST["news"]))

{

    $tm=md5 (time());
    $image=$_FILES["nimage"]["name"];
    $dst="../imagen/".$tm.$image;
    $dst1="imagen/".$tm.$image;

    move_uploaded_file($_FILES["nimage"]["tmp_name"],$dst);

    if(empty($image) ){
        
        mysqli_query($con,"UPDATE `news` SET title='$_POST[title]', description='$_POST[description]' WHERE id=$id") or die(mysqli_error($con)); 
     
     ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "newss.php";
}, 1000);
</script>
<?php

exit();
    }

else{



    mysqli_query($con,"UPDATE `news` SET title='$_POST[title]', description='$_POST[description]', image='$dst1' WHERE id=$id") or die(mysqli_error($con)); 

    ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "newss.php";
}, 1000);
</script>
<?php

}
 }



?>


<?php
include('footer.php');
?>