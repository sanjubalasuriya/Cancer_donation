<?php

include('header.php');
$uname = $_SESSION['uname'];


?>




<div class="container_admin">
    <div class="table_title">
        <h1>Profile</h1>


    </div>
    <hr>
    <div class="" id="csign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Password Changed Successfully!
    </div>

    <div class="">
        <?php
                if(isset($_SESSION['error'])){
                    echo"
                    <div class='alert alert-warning text-center'>
                    
                    ".$_SESSION['error']."
                    </div>
                    ";
                    unset($_SESSION['error']);
                }

                if(isset($_SESSION['success'])){
                    echo"
                    <div class='alert alert-success text-center'>
                    
                    ".$_SESSION['success']."
                    </div>
                    ";
                    unset($_SESSION['success']);

                }
                ?>

        <div class="content_form">
            <form method="POST" action="pro.php">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">User Name</label>
                        <input type="text" placeholder="Enter First name" required name="uname"
                            value="<?php echo $uname;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Currunt Password</label>
                        <input type="text" placeholder="Enter Currunt Password" required name="password">
                    </div>
                    <div class="input-box">
                        <label class="labels">New Password</label>
                        <input type="text" placeholder="Enter New Password" required name="npass">
                    </div>
                    <div class="input-box">
                        <label class="labels">Confirm Password</label>
                        <input type="text" placeholder="Enter Confirm Password" required name="cpass">
                    </div>

                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Register" name="psubmit" id="psubmit">
                </div>
            </form>
        </div>

    </div>

</div>



<?php
include('footer.php');
?>