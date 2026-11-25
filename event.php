<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/commen/header.php'; ?>

    <section class="container donate_container">
        <h1>Events</h1>
        <h3>Community programs organized by Save Life Cancer Foundation</h3>
        <hr>
    </section>

    <section class="container">
        <?php
        $events = [];
        $res = mysqli_query($con, 'SELECT `id`, `title`, `location`, `image`, `date` FROM `event` ORDER BY `date` DESC, `id` DESC');
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $events[] = $row;
            }
        }
        ?>

        <?php if (empty($events)): ?>
            <div class="empty-state">
                <h3>No Upcoming Events</h3>
                <p>New fundraising and awareness events will be announced here soon.</p>
            </div>
        <?php else: ?>
            <div class="event_cards">
                <?php foreach ($events as $row): ?>
                    <article class="event_card">
                        <div class="event_img">
                            <img src="<?php echo e($row['image']); ?>" alt="<?php echo e($row['title']); ?>">
                        </div>
                        <div class="event_card-body">
                            <div class="event_title">
                                <h2><?php echo e($row['title']); ?></h2>
                            </div>
                            <div class="event_description">
                                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                <span><?php echo e($row['location']); ?></span>
                            </div>
                            <?php if (!empty($row['date'])): ?>
                                <div class="event_date">
                                    <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                    <?php echo e($row['date']); ?>
                                </div>
                            <?php endif; ?>
                            <div style="margin-top:auto;padding-top:0.5rem;">
                                <a href="events.php?id=<?php echo (int)$row['id']; ?>" class="btn btn-sm">Read More</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

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
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
