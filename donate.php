<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/commen/header.php'; ?>

    <section class="container donate_container">
        <h1>Donate</h1>
        <h3>Choose how you would like to support the Fight Cancer Foundation</h3>
        <hr>
    </section>

    <section class="container">
        <div class="donate_cards">
            <article class="donate_card">
                <div>
                    <div class="donate_card-icon"><i class="fas fa-id-card"></i></div>
                    <div class="donate_head">
                        <h3>Be a Member</h3>
                    </div>
                    <p>Join the Save Life Foundation with an annual membership or renew your existing membership.</p>
                </div>
                <a href="member.php" class="btn">Join / Renew</a>
            </article>

            <article class="donate_card">
                <div>
                    <div class="donate_card-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <div class="donate_head">
                        <h3>Treatment for High-Risk Patients</h3>
                    </div>
                    <p>Contribute directly toward urgent medical treatment costs for registered cancer patients.</p>
                </div>
                <a href="money.php" class="btn">View Patients</a>
            </article>

            <article class="donate_card">
                <div>
                    <div class="donate_card-icon"><i class="fas fa-box-open"></i></div>
                    <div class="donate_head">
                        <h3>Donate Essential Items</h3>
                    </div>
                    <p>View urgently needed sanitary items, medicines, hospital equipment, and nutrition supplies.</p>
                </div>
                <a href="item.php" class="btn">View Item List</a>
            </article>

            <article class="donate_card">
                <div>
                    <div class="donate_card-icon"><i class="fas fa-hospital"></i></div>
                    <div class="donate_head">
                        <h3>Donate for Hospital</h3>
                    </div>
                    <p>Support new hospital infrastructure and life-saving diagnostic equipment like PET scan machines.</p>
                </div>
                <a href="hospital.php" class="btn">Donate Now</a>
            </article>

            <article class="donate_card">
                <div>
                    <div class="donate_card-icon"><i class="fas fa-child"></i></div>
                    <div class="donate_head">
                        <h3>Donate for Children</h3>
                    </div>
                    <p>Bring comfort and support to young patients by donating stationery, school bags, shoes, and toys.</p>
                </div>
                <a href="child.php" class="btn">View Children's Needs</a>
            </article>

            <article class="donate_card">
                <div>
                    <div class="donate_card-icon"><i class="fas fa-cut"></i></div>
                    <div class="donate_head">
                        <h3>Donate Hair</h3>
                    </div>
                    <p>Locate your nearest registered partner salon on the map to donate hair for patient wigs.</p>
                </div>
                <a href="organ.php" class="btn">Find a Salon</a>
            </article>
        </div>
    </section>

    <?php include __DIR__ . '/commen/footer.php'; ?>
</body>
</html>
