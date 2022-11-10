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


    <section class="container donate_container">
        <h1>Treatment of high-risk Patients</h1>
        <h3>Donate to Fight Cancer Foundation</h3>
        <hr>
    </section>

    <section class="container">

        <?php 
         $res=mysqli_query($con,"SELECT * FROM `patients` ORDER BY amount DESC");
         while($row=mysqli_fetch_array($res))
         {

            $amount=$row["amount"];
            $donation=$row["donate"];

            if($amount > $donation){
        
        ?>


        <div class="news">
            <div class="news_img">
                <!-- <img src="img/patients1.jpg" alt=""> -->
                <img src="<?php echo $row["image"]; ?>" alt="image">
            </div>
            <div class="news_des">
                <div class="news_description">
                    <p>Hey..! I am <?php echo $row["f_name"]; ?> <?php echo $row["l_name"]; ?>. I have
                        <?php echo $row["cancer"]; ?> . You can contribute to my treatment
                        Thanks..</p>
                </div>

                <p><b>Total Amount need</b> : <?php echo $row["amount"]; ?></p>
                <p><b>Amount received</b> : <?php echo $row["donate"]; ?></p>
                <a class="btn news_btn" href="transfer.php?id=<?php echo $row["id"]; ?>">Donate</a>
            </div>



        </div>


        <?php
         }
         }
         ?>



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