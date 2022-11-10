<?php include('../db/db.php');

    $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $nic = $_POST["nic"];
    $contact = $_POST["contact"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $cancer = $_POST["cancer"];
    $c_step = $_POST["c_step"];
    $amount = $_POST["amount"];
    $address = $_POST["address"];

    $name = "/^[A-Z][a-zA-Z]+$/";
    $emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
    $number = "/^[0-9]+$/";
    
    


    if(empty($f_name) || empty($l_name) || empty($nic) || empty($contact) || empty($email) || empty($dob) 
    || empty($gender) || empty($cancer) || empty($c_step) || empty($amount) || empty($address) ){


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

            $sql = "INSERT INTO `patients`(`id`, `f_name`, `l_name`, `nic`, `contact`, `email`, `dob`, `gender`, `cancer`, `c_step`, `amount`, `address`, `image`) VALUES 
            (NULL,'$f_name','$l_name','$nic','$contact','$email','$dob','$gender','$cancer','$c_step','$amount','$address', '')";
            $result = mysqli_query($con,$sql);
            
            if($result){

            

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