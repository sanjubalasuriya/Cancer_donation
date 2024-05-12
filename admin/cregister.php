<link rel="stylesheet" type="text/css" href="style.css">

<?php 

include ('../db/db.php');



$num = $_POST["num"];
$name = $_POST["name"];




if(empty($num) || empty($name) ){


    echo "
            <div class=' alert-warning' role='alert'>
            
                      <b>  Fill All Fields...</b>
            </div>

    ";
    exit();
}
else{

$sql = "INSERT INTO `cancers` (`id`, `num`, `name`) VALUES (NULL, '$num', '$name')";

        


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