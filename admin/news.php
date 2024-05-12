<?php
include('header.php');
include ('../db/db.php');
?>





<div class="container_admin">
    <div class="table_title">
        <h1>Add News</h1>


    </div>
    <hr>
    <div class="" id="news_sign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        News added Successfully!
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">Title</label>
                        <input type="text" placeholder="Enter Title" required name="title">
                    </div>



                    <div class="input-box">
                        <label class="labels">Image</label>
                        <input type="file" placeholder="Enter Image" required name="nimage">
                    </div>
                    <div class="input-box">
                        <label class="labels">Description</label>

                        <textarea cols="30" rows="10" type="text" placeholder="Enter Description" required
                            name="description"></textarea>
                    </div>


                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Register" name="news" id="news">
                    <a href="newss.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>

<?php 



if(isset($_POST["news"])){

$title = $_POST["title"];
$description = $_POST["description"];



$tm=md5 (time());
$image=$_FILES["nimage"]["name"];
$dst="../imagen/".$tm.$image;
$dst1="imagen/".$tm.$image;

move_uploaded_file($_FILES["nimage"]["tmp_name"],$dst);




$sql = "INSERT INTO `news` (`id`, `title`, `image`, `description` ) 
VALUES (NULL, '$title', '$dst1', '$description')";

        


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