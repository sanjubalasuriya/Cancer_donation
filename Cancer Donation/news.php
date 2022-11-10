<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="shotcut icon" href="img/Logo..png" type="x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Save Life</title>

    <link rel="stylesheet" href="index.css">
    <link rel="shotcut icon" href="img/logo.png" type="x-icon">
</head>

<body>
    <?php
include('commen/header.php');
?>

    <section class="container donate_container">
        <h1>News</h1>
        <h3>News to Fight Cancer Foundation</h3>
    </section>

    <div class="container news_container">

        <hr>


        <?php 
                $res=mysqli_query($con,"SELECT * FROM `news`");
                while($row=mysqli_fetch_array($res))
                {
                ?>

        <div class="news">
            <div class="news_img">
                <img src="<?php echo $row["image"]; ?>" alt=" image">

            </div>
            <div class="news_des">
                <div class="news_description">
                    <h2><?php echo $row["title"]; ?></h2>
                </div>
                <a href="newss.php?id=<?php echo $row["id"]; ?>" class="btn event_btn">Read More...</a>
            </div>

        </div>

        <?php 
                }
                ?>

    </div>

    </div>

    <div class="section3">

    </div>
    <div class="footer_margin">

    </div>
    <?php
include('commen/footer.php');
?>

    <script src="commen/script.js"></script>
</body>

</html>