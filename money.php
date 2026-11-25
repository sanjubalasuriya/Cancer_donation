<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
=======

>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>High-Risk Patients | Save Life</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<body>
    <?php include __DIR__ . '/commen/header.php'; ?>

    <section class="container donate_container">
        <h1>Treatment of High-Risk Patients</h1>
        <h3>Direct financial support for patients awaiting urgent care</h3>
=======
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
include('db/db.php');
?>


    <section class="container donate_container">
        <h1>Treatment of high-risk Patients</h1>
        <h3>Donate to Fight Cancer Foundation</h3>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
        <hr>
    </section>

    <section class="container">
<<<<<<< HEAD
        <?php
        $patients = [];
        $res = mysqli_query($con, 'SELECT `id`, `f_name`, `l_name`, `cancer`, `c_step`, `amount`, `donate`, `image` FROM `patients` WHERE `amount` > `donate` ORDER BY (`amount` - `donate`) DESC');
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $patients[] = $row;
            }
        }
        ?>

        <?php if (empty($patients)): ?>
            <div class="empty-state">
                <h3>All Registered Patients Are Currently Funded</h3>
                <p>Thank you to our generous donors! You can still support hospital infrastructure or become a foundation member.</p>
                <a href="hospital.php" class="btn">Donate to Hospital</a>
            </div>
        <?php else: ?>
            <div class="cards-stack">
                <?php foreach ($patients as $row):
                    $needed = max(1, (int)$row['amount']);
                    $received = max(0, (int)$row['donate']);
                    $remaining = max(0, $needed - $received);
                    $pct = min(100, (int)round(($received / $needed) * 100));
                ?>
                    <article class="news">
                        <div class="news_img">
                            <img src="<?php echo e($row['image'] ?: 'img/patients1.jpg'); ?>" alt="<?php echo e($row['f_name'] . ' ' . $row['l_name']); ?>">
                        </div>
                        <div class="news_des">
                            <div class="news_description">
                                <h3><?php echo e($row['f_name'] . ' ' . $row['l_name']); ?></h3>
                                <p>
                                    Diagnosed with <strong><?php echo e($row['cancer']); ?></strong>
                                    <?php if (!empty($row['c_step'])): ?>
                                        (<?php echo e($row['c_step']); ?>)
                                    <?php endif; ?>.
                                    Your contribution directly supports my treatment.
                                </p>
                            </div>

                            <div class="progress-track" aria-label="Funding progress <?php echo $pct; ?>%">
                                <div class="progress-fill" style="width: <?php echo $pct; ?>%;"></div>
                            </div>

                            <div class="funding-meta">
                                <span>Goal: <strong>Rs. <?php echo number_format($needed); ?></strong></span>
                                <span>Raised: <strong>Rs. <?php echo number_format($received); ?></strong> (<?php echo $pct; ?>%)</span>
                                <span>Remaining: <strong>Rs. <?php echo number_format($remaining); ?></strong></span>
                            </div>

                            <div>
                                <a class="btn btn-sm" href="transfer.php?id=<?php echo (int)$row['id']; ?>">Donate Now</a>
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

        <?php 
         $res=mysqli_query($con,"SELECT * FROM `patients` ORDER BY amount DESC");
         while($row=mysqli_fetch_array($res))
         {

            $amount=$row["amount"];
            $donation=$row["donate"];

            if($amount > $donation){
        
        ?>


        <div class="news">
            <div class="news_img">
                <!-- <img src="img/patients1.jpg" alt=""> -->
                <img src="<?php echo $row["image"]; ?>" alt="image">
            </div>
            <div class="news_des">
                <div class="news_description">
                    <p>Hey..! I am <?php echo $row["f_name"]; ?> <?php echo $row["l_name"]; ?>. I have
                        <?php echo $row["cancer"]; ?> . You can contribute to my treatment
                        Thanks..</p>
                </div>

                <p><b>Total Amount need</b> : <?php echo $row["amount"]; ?></p>
                <p><b>Amount received</b> : <?php echo $row["donate"]; ?></p>
                <a class="btn news_btn" href="transfer.php?id=<?php echo $row["id"]; ?>">Donate</a>
            </div>



        </div>


        <?php
         }
         }
         ?>



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
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
