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
include('commen/header.php');
include('db/db.php');
?>


    <section class="home" id="home">


        <div class="content1">
            <h3>For the treatment of high-risk patients</h3>
            <p><b> </b></p>
            <a href="money.php" class="btn">Donate >>></a>
        </div>



    </section>

    <section class="container ">
        <div class="home2">
            <div class="sponsor_title">
                <h1>Sponsors of Save Life Foundation</h1>
                <p>Join hands and come forward to save cancer patients</p>
            </div>


            <div class="sponsor_logo">
                <?php 
         $res=mysqli_query($con,"SELECT * FROM `sponsors` ");
         while($row=mysqli_fetch_array($res))
         {
        
        ?>
                <!-- <img src="img/keellslogo.png" alt="logo"> -->
                <img src="<?php echo $row["image"]; ?>" width="50px;" heigth="50px;" alt="image">
                <?php

         }
                ?>


            </div>
        </div>
    </section>
    <div class="section3">
        <div class="img-over">
            <section class="container ">
                <div class="home2">
                    <div class="sec3_title">
                        <h1>Always take care of your health</h1>
                        <p>Join hands and come forward to save cancer patients</p>
                    </div>
                    <p></p>
                    <center><a href="read.php" class="btn">Read More...</a></center>

                </div>
            </section>
        </div>
    </div>







    <?php
include('commen/footer.php');
?>
    <!-- custom js file link  -->
    <script src="commen/script.js"></script>

</body>

</html>