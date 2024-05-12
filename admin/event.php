<?php
include('header.php');
include ('../db/db.php');
?>





<div class="container_admin">
    <div class="table_title">
        <h1>Add Event</h1>


    </div>
    <hr>
    <div class="" id="event_sign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Event added Successfully!
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
                        <label class="labels">Location</label>
                        <input type="text" placeholder="Enter location" required name="location">
                    </div>

                    <div class="input-box">
                        <label class="labels">Image</label>
                        <input type="file" placeholder="Enter Image" required name="eimage">
                    </div>
                    <div class="input-box">
                        <label class="labels">Date</label>
                        <input type="date" placeholder="Enter Description" required name="date">
                    </div>
                    <div class="input-box">
                        <label class="labels">Description</label>

                        <textarea rows="10" type="text" placeholder="Enter Description" required
                            name="description"></textarea>
                    </div>

                </div>

                <div class="button">
                    <input type="submit" class="btn" value="ADD" name="event" id="event">
                    <a href="events.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>

<?php 



if(isset($_POST["event"])){

$title = $_POST["title"];
$location = $_POST["location"];
$description = $_POST["description"];
$date = $_POST["date"];


$tm=md5 (time());
$image=$_FILES["eimage"]["name"];
$dst="../imagee/".$tm.$image;
$dst1="imagee/".$tm.$image;

move_uploaded_file($_FILES["eimage"]["tmp_name"],$dst);


if(empty($title) || empty($description) ){


    echo "
            <div class=' alert-warning' role='alert'>
            
                      <b>  Fill All Fields...</b>
            </div>

    ";
    exit();
}
else{

$sql = "INSERT INTO `event` (`id`, `title`, `location`, `description`, `image`, `date`) 
VALUES (NULL, '$title', '$title', '$description', '$dst1', '$date')";

        


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
    
    }
    

?>


<?php
include('footer.php');
?>