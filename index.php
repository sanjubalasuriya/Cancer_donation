<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Life Cancer Foundation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/commen/header.php'; ?>

    <section class="home" id="home">
        <div class="container">
            <div class="content1">
                <span class="hero-eyebrow">Save Life Cancer Foundation</span>
                <h1>Support Treatment for High-Risk Patients</h1>
                <p>Every contribution helps fund critical cancer care, hospital equipment, and direct patient support across Sri Lanka.</p>
                <div class="hero-actions">
                    <a href="money.php" class="btn">Donate to Patients <i class="fas fa-arrow-right"></i></a>
                    <a href="donate.php" class="btn btn-secondary">All Ways to Help</a>
                </div>
            </div>
        </div>
    </section>

    <section class="container section-block">
        <div class="section-header">
            <h2>Sponsors of Save Life Foundation</h2>
            <p>Partnering together to bring hope and timely treatment to cancer patients.</p>
        </div>

        <?php
        $sponsors = [];
        $res = mysqli_query($con, 'SELECT `company`, `image` FROM `sponsors` ORDER BY `id` ASC');
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $sponsors[] = $row;
            }
        }
        ?>

        <?php if (empty($sponsors)): ?>
            <div class="empty-state">
                <h3>Become Our Founding Sponsor</h3>
                <p>Partner organizations supporting cancer care will be featured here.</p>
                <a href="contact.php" class="btn">Partner With Us</a>
            </div>
        <?php else: ?>
            <div class="sponsor_logo">
                <?php foreach ($sponsors as $sponsor): ?>
                    <div class="sponsor-item">
                        <img src="<?php echo e($sponsor['image']); ?>" alt="<?php echo e($sponsor['company']); ?> logo">
                        <span><?php echo e($sponsor['company']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="section3">
        <div class="img-over">
            <div class="container">
                <div class="sec3_title">
                    <h1>Always Take Care of Your Health</h1>
                    <p>Learn about cancer awareness, early signs, and patient statistics in our community.</p>
                    <a href="read.php" class="btn">Read Awareness Guide</a>
                </div>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/commen/footer.php'; ?>
</body>
</html>
