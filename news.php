<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/commen/header.php'; ?>

    <section class="container donate_container">
        <h1>News &amp; Updates</h1>
        <h3>Latest announcements and healthcare stories from Save Life Foundation</h3>
        <hr>
    </section>

    <section class="container">
        <?php
        $newsList = [];
        $res = mysqli_query($con, 'SELECT `id`, `title`, `image`, `description`, `date` FROM `news` ORDER BY `date` DESC, `id` DESC');
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $newsList[] = $row;
            }
        }
        ?>

        <?php if (empty($newsList)): ?>
            <div class="empty-state">
                <h3>No News Published Yet</h3>
                <p>Check back soon for updates on our programs and impact.</p>
            </div>
        <?php else: ?>
            <div class="cards-stack">
                <?php foreach ($newsList as $row):
                    $excerpt = mb_strimwidth(strip_tags((string)$row['description']), 0, 180, '...');
                ?>
                    <article class="news">
                        <div class="news_img">
                            <img src="<?php echo e($row['image']); ?>" alt="<?php echo e($row['title']); ?>">
                        </div>
                        <div class="news_des">
                            <div class="news_description">
                                <h2><?php echo e($row['title']); ?></h2>
                                <?php if ($excerpt !== ''): ?>
                                    <p><?php echo e($excerpt); ?></p>
                                <?php endif; ?>
                            </div>
                            <div>
                                <a href="newss.php?id=<?php echo (int)$row['id']; ?>" class="btn btn-sm">Read Full Story</a>
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
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
