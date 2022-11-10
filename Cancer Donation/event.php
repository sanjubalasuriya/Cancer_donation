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
        <h1>Events</h1>
        <h3>Events organize for Fight Cancer Foundation</h3>
        <hr>
    </section>

    <section class="container event_container">
        <div class="event_cards">

            <?php 
                $res=mysqli_query($con,"SELECT * FROM `event`");
                while($row=mysqli_fetch_array($res))
                {
                ?>
            <div class="event_card">
                <div class="event_title">
                    <h2><?php echo $row["title"]; ?></h2>
                </div>
                <div class="event_img"><img src="<?php echo $row["image"]; ?>" alt=" image"></div>
                <div class="event_description"><?php echo $row["location"]; ?></div>
                <a href="events.php?id=<?php echo $row["id"]; ?>" class="btn event_btn">Read More...</a>

            </div>

            <?php 
                }
                ?>

        </div>
    </section>
    <div class="footer_margin">

    </div>

    <?php
include('commen/footer.php');
?>

    <script src="commen/script.js"></script>
</body>

</html>