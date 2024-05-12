<link rel="stylesheet" type="text/css" href="style.css">

<?php 

include ('../db/db.php');



$title = $_POST["title"];
$location = $_POST["location"];
$description = $_POST["description"];
$date = $_POST["date"];
$img = $_POST["img"];




if(empty($title) || empty($description) ){


    echo "
            <div class=' alert-warning' role='alert'>
            
                      <b>  Fill All Fields...</b>
            </div>

    ";
    exit();
}
else{

$sql = "INSERT INTO `news` (`id`, `title`, `img`, `description`, `date`) 
VALUES (NULL, '$title', '$img', '$description', '$date')";

        


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