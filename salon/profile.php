<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Life</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="index.css">
    <link rel="shotcut icon" href="../img/logo.png" type="x-icon">


</head>

<body>


    <?php
include('header.php');
?>

    <section class="container donate_container">
        <h1>Profile</h1>
        <h3>Change Password</h3>
        <hr>
    </section>

    <section class="container">

        <div class="" id="organ_sign">

        </div>
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

        <div class="container member_form">
            <form action="pro.php" method="post">
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Username</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="" name="uname" value="<?php echo $uname; ?>" placeholder="Your name.."
                            readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Currunt Password</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="" name="password" placeholder="Your name..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">New Password</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="" name="npass" placeholder="Your name..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="lname">Confirm Password</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="" name="cpass" placeholder="Amount of your donation">
                    </div>
                </div>

                <br>
                <div class="row transfer">
                    <button class="btn" name="psubmit" id="psubmit" type="submit">Change Password</button>
                </div>
            </form>
        </div>

    </section>
    <div class="footer_margin">

    </div>








    <?php
include('footer.php');
?>
    <!-- custom js file link  -->
    <script src="../commen/script.js"></script>

</body>

</html>