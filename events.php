<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php
    include __DIR__ . '/commen/header.php';

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $eventItem = null;
    if ($id && $id > 0) {
        $stmt = mysqli_prepare($con, 'SELECT `id`, `title`, `location`, `image`, `description`, `date` FROM `event` WHERE `id` = ? LIMIT 1');
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $eventItem = $res ? mysqli_fetch_assoc($res) : null;
            mysqli_stmt_close($stmt);
        }
    }
    ?>

    <?php if (!$eventItem): ?>
        <section class="container donate_container">
            <div class="empty-state">
                <h3>Event Not Found</h3>
                <p>The requested event could not be located or may have been removed.</p>
                <a href="event.php" class="btn">Back to Events</a>
            </div>
        </section>
    <?php else: ?>
        <section class="container donate_container">
            <h1><?php echo e($eventItem['title']); ?></h1>
            <h3><?php echo e($eventItem['location']); ?><?php echo !empty($eventItem['date']) ? ' &bull; ' . e($eventItem['date']) : ''; ?></h3>
            <hr>
        </section>

        <section class="container">
            <div class="eimage">
                <img src="<?php echo e($eventItem['image']); ?>" alt="<?php echo e($eventItem['title']); ?>">
            </div>

            <div class="ediscription">
                <p><?php echo nl2br(e($eventItem['description'])); ?></p>
            </div>

            <div class="form-actions">
                <a href="event.php" class="btn btn-secondary">&larr; Back to All Events</a>
            </div>
        </section>
    <?php endif; ?>

    <?php include __DIR__ . '/commen/footer.php'; ?>
</body>
</html>
=======

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
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
