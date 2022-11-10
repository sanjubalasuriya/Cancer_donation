<link rel="stylesheet" type="text/css" href="style.css">

<?php 

include ('../db/db.php');



$f_name = $_POST["f_name"];
$l_name = $_POST["l_name"];
$contact = $_POST["contact"];
$email = $_POST["email"];
$company = $_POST["company"];

$emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";


if(empty($f_name) || empty($l_name) || empty($contact) || empty($email) || empty($company) ){


    echo "
            <div class=' alert-warning' role='alert'>
            
                      <b>  Fill All Fields...</b>
            </div>

    ";
    exit();
}
if(!preg_match($emailValidation,$email)){
    echo "
    <div class=' alert-warning' role='alert'>
        <b> This email ' $email ' is not valid...!</b>
    </div>
    
    ";
    exit();
}

if(!(strlen($contact) == 10)){
    echo "
    <div class='alert alert-warning' role='alert'>
        <b>  Mobile number should be 10 digit...!</b>
    </div>
    
    ";
    exit();
}
else{

$sql = "INSERT INTO `sponsors` (`id`, `f_name`, `l_name`, `email`, `contact`,  `company`) 
VALUES (NULL, '$f_name', '$l_name', '$email', '$contact', '$company')";

        


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