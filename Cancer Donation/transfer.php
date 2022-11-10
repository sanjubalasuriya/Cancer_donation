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
    <link rel="shotcut icon" href="img/logo.png" type="x-icon">


</head>

<body>


    <?php
    include ('db/db.php');
include('commen/header.php');


$id=$_GET["id"];

$fname="";
$lname="";
$p_id="";
$iid="";
$donate="";



$res=mysqli_query($con,"SELECT * FROM `patients` WHERE id=$id");  
while($row=mysqli_fetch_array($res))
{
   
    $fname=$row["f_name"];
    $lname=$row["l_name"];
    $p_id=$row["p_id"];
    $iid=$row["id"];
    $donate=$row["donate"];
}
?>



    <section class="container donate_container">
        <h1>Donate to <?php echo $fname;?> <?php echo $lname;?></h1>
        <h3>Donate High-risk Patients to save their life</h3>
        <hr>
    </section>

    <section class="container">

        <div class="" id="transfer_sign">

        </div>

        <div class="container donate_form">
            <form method="POST">
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Your First Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="f_name" name="p_id" placeholder="Your name.." hidden
                            value="<?php echo $p_id;?>">
                    </div>
                    <div class="col-75">
                        <input type="text" id="f_name" name="iid" placeholder="Your name.." hidden
                            value="<?php echo $id;?>">
                    </div>
                    <div class="col-75">
                        <input type="text" id="f_name" name="donate" placeholder="Your name.." hidden
                            value="<?php echo $donate;?>">
                    </div>
                    <div class="col-75">
                        <input type="text" id="f_name" name="f_name" placeholder="Your name..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label>Your Last Name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="l_name" placeholder="Your name..">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label>Phone No</label>
                    </div>
                    <div class="col-75">
                        <input type="number" name="contact" placeholder="Your Phone no..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label>Email</label>
                    </div>
                    <div class="col-75">
                        <input type="email" name="email" placeholder="Your Email..">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label>Amount (Rs)</label>
                    </div>
                    <div class="col-75">
                        <input type="number" name="amount" placeholder="Amount of your donation">
                    </div>
                </div>




                <br>
                <div class="row transfer">
                    <button class="btn" name="transfer" id="transfer" type="submit">Submit</button>
                </div>
            </form>
        </div>

    </section>
    <div class="footer_margin">

    </div>








    <?php
include('commen/footer.php');
?>
    <!-- custom js file link  -->
    <script src="commen/script.js"></script>

</body>

</html>