<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Items | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/commen/header.php'; ?>

    <section class="container donate_container">
        <h1>Donate Items</h1>
        <h3>Please contact our team before dropping off medical or sanitary supplies</h3>
        <hr>
    </section>

    <section class="container">
        <div class="cancer_list">
            <div class="item-group">
                <h3>Sanitary Supplies</h3>
                <ul>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Soap</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Razor</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Dettol Antiseptic</li>
                </ul>
            </div>

            <div class="item-group">
                <h3>Medicine</h3>
                <ul>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Inj. Cisplatin 50mg</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Inj. Oxaliplatin 100mg</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Inj. Irinotecan 100mg</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Tab. Anastrozole 1mg</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Tab. Capecitabine 500mg</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Inj. Filgrastim 300mcg</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Inj. Melphalan 50mg</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Inj. Gemcitabine 1g</li>
                </ul>
            </div>

            <div class="item-group">
                <h3>Hospital Equipment</h3>
                <ul>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Hospital Bed</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Pillow</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Wheelchair</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Bench</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Cupboard</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Stand Fan</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Stool</li>
                </ul>
            </div>

            <div class="item-group">
                <h3>Nutrition &amp; Fresh Food</h3>
                <ul>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Fresh Vegetables</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> Fresh Fruits</li>
                    <li><ion-icon name="chevron-forward-outline"></ion-icon> King Coconut</li>
                </ul>
            </div>
        </div>

        <div class="form-actions">
            <a href="contact.php" class="btn">Contact Us to Arrange Drop-Off</a>
        </div>
    </section>

    <?php include __DIR__ . '/commen/footer.php'; ?>
</body>
</html>
