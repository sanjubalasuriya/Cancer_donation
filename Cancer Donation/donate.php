<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Life</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="index.css">
    <link rel="shotcut icon" href="img/logo.png" type="x-icon">


</head>

<body>


    <?php
include('commen/header.php');
?>

    <section class="container donate_container">
        <h1>Donate</h1>
        <h3>Donate to Fight Cancer Foundation</h3>
    </section>

    <section class="container donate_container2">

        <h3>How you can donate patients to save their life</h3>

        <hr>

        <div class="donate_cards">
            <div class="donate_card">
                <div class="donate_head">
                    <h3>Be a Member</h3>
                </div>

                <p>You can be a member in Save Life foundation</p>

                <a href="member.php" class="btn">Donate</a>
            </div>

            <div class="donate_card">
                <div class="donate_head">
                    <h3>Donate for the treatment of high-risk patients</h3>
                </div>

                <p>You can donate money for cancer patients to save their life.</p>
                <a href="money.php" class="btn">Donate</a>
            </div>

            <div class="donate_card">
                <div class="donate_head">
                    <h3>Donate Items</h3>
                </div>

                <p>You can donate items for cancer patients</p>
                <a href="item.php" class="btn">Donate</a>
            </div>

            <div class="donate_card">
                <div class="donate_head">
                    <h3>Donate for Hospital</h3>
                </div>

                <p>You can donate items for cancer patients</p>
                <a href="hospital.php" class="btn">Donate</a>
            </div>

            <div class="donate_card">
                <div class="donate_head">
                    <h3>Donate for Childrens</h3>
                </div>

                <p>You can donate items for cancer patients</p>
                <a href="child.php" class="btn">Donate</a>
            </div>

            <div class="donate_card">
                <div class="donate_head">
                    <h3>Donate Hair</h3>
                </div>

                <p>You can donate Organ for cancer patients</p>
                <a href="organ.php" class="btn">Donate</a>
            </div>
        </div>


    </section>
    <div class="footer_margin">

    </div>









    <?php
include('commen/footer.php');
?>
    <!-- custom js file link  -->
    <script src="commen/script.js"></script>

</body>

</html>