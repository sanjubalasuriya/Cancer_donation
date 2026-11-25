<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/commen/header.php'; ?>

    <section class="container donate_container">
        <h1>About Save Life</h1>
        <h3>Dedicated to supporting cancer patients and their families</h3>
        <hr>
    </section>

    <section class="container">
        <div class="content-card read2">
            <h3><ion-icon name="heart-outline"></ion-icon> Our Mission</h3>
            <p>
                The Save Life Cancer Foundation was established in 2018 as a charitable organization dedicated to one clear
                purpose: creating practical, compassionate support for cancer patients to ease and improve their treatment
                journey so their energies remain focused on getting well.
            </p>

            <h3><ion-icon name="medkit-outline"></ion-icon> Founded by Specialists</h3>
            <p>
                Our founders are doctors and cancer treatment specialists. We understand the cancer treatment journey and
                its daily challenges, and know that a holistic, caring support system makes a real difference for patients
                and their families.
            </p>

            <h3><ion-icon name="people-outline"></ion-icon> Community-Focused Care</h3>
            <p>
                We are local and community focused, staying close to the ways direct, practical, and immediate help is
                needed &mdash; from funding urgent high-risk treatments and hospital equipment to organizing hair donations
                and essential supplies.
            </p>

            <div class="form-actions">
                <a href="donate.php" class="btn">Explore Ways to Donate</a>
                <a href="contact.php" class="btn btn-outline">Contact Us</a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/commen/footer.php'; ?>
</body>
</html>
