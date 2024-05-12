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
    include ('db/db.php');
include('commen/header.php');


$id=$_GET["id"];

$fname="";
$lname="";
$p_id="";
$iid="";
$donate="";



$res=mysqli_query($con,"SELECT * FROM `event` WHERE id=$id");  
while($row=mysqli_fetch_array($res))
{
   
    

?><section class="container donate_container">
        <h1><?php echo $row["title"]; ?></h1>
        <h3><?php echo $row["location"]; ?></h3>
        <hr>
    </section>

    <section class="container event_container">

        <center>
            <div class="eimage"><img src="<?php echo $row["image"]; ?>" alt=" image"></div>
        </center>

        <div class="ediscription">
            <p><?php echo $row["description"]; ?></p>
        </div>

        <?php } ?>

    </section>
    <div class="footer_margin">

    </div>

    <?php
include('commen/footer.php');
?>

    <script src="commen/script.js"></script>
</body>

</html>