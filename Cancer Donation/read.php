<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="shotcut icon" href="img/Logo..png" type="x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Save Life</title>

    <link rel="stylesheet" href="index.css">
    <link rel="shotcut icon" href="img/logo.png" type="x-icon">
</head>

<body>
    <?php
    include('commen/header.php');
    include('db/db.php');

    ?>

    <section class="container donate_container">
        <h1>Cancer</h1>
        <h3>Always take care your Family</h3>
        <hr>
    </section>

    <section class="container read2">
        <h3>
            <ion-icon name="medkit-outline"></ion-icon>How Cancer Starts
        </h3>
        <p>Your body is made up of trillions of living cells. Within each cell are genes that control and direct the
            cell’s functions. Normal cells continuously grow and divide. Over time, they die and are replaced by new
            ones.
            In most people, this natural cell replacement occurs in an orderly and organized manner. However, this
            process sometimes breaks down. Unlike normal healthy cells, cancer cells do not die. Instead, they continue
            to grow and divide in an uncontrollable manner. These defective cells may form a mass of tissue called a
            tumor.
        </p>

        <h3>
            <ion-icon name="medkit-outline"></ion-icon>What Are Tumors
        </h3>
        <p>Tumors can be benign or malignant. Tumors that stay in one location and do not spread to other parts of the
            body are considered to be benign. These are not cancerous and are rarely life-threatening although they can
            sometimes cause problems, especially when they grow too big.
            On the other hand, malignant tumors can destroy and invade other normal tissues in your body, making you
            very sick. However, not all types of cancer form tumors. For instance, tumors are uncommon in leukemia.
            These are cancers that typically start in the bone marrow and enter the bloodstream.
        </p>

        <h3>
            <ion-icon name="medkit-outline"></ion-icon>When Cancer Spreads
        </h3>
        <p>Cancer cells can spread when they migrate to other parts of the body through the blood and lymph systems,
            forming new tumors. This process is called metastasis. Even when cancer spreads, it is always named based on
            where it first occurred. For instance, cancer that begins in the breast is called breast cancer. If it
            spreads to other parts of the body, like the liver or bone, it is called metastatic breast cancer.
            With so many different cancers, it is important for you to know which type of cancer you have so that you
            can receive the right treatment.
        </p>

        <div class="cancer_list">
            <h3>Most common Cancers</h3>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Bladder Cancer
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Bladder Cancer
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Colon and Rectal Cancer
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Endometrial Cancer
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Kidney Cancer
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Leukemia
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Liver Cancer
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Lung Cancer
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Melanoma
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Non-Hodgkin Lymphoma
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Pancreatic Cancer
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Prostate Cancer
            </li>
            <li>
                <ion-icon name="chevron-forward-outline"></ion-icon>Thyroid Cancer
            </li>
        </div>

    </section>
    <section class="container read3">
        <h1>Cancer Charts</h1>
        <h3>Always take care your Family</h3>
        <hr>

        <?php

$res=mysqli_query($con,"SELECT MONTHNAME(date) as mname, COUNT(*) as row FROM patients GROUP BY MONTH(date)");
$amount = array();
$month = array();

                while($row=mysqli_fetch_array($res))
                {
                    
$amount[] = $row["row"];
$month[] = $row["mname"];

                }

?>


        <div class="patient_month">
            <canvas id="pmonth" height="120"></canvas>
        </div>


    </section>
    <div class="footer_margin">

    </div>

    <script>
    const amount = <?php echo json_encode($amount); ?>

    const data = {
        labels: <?php echo json_encode($month); ?>,
        datasets: [{
            label: '',
            data: amount,
            backgroundColor: [
                'rgba(190, 4, 4)',
                'rgba(190, 4, 4)',
                'rgba(190, 4, 4)',
                'rgba(190, 4, 4)',
                'rgba(190, 4, 4)',
                'rgba(190, 4, 4)',
            ],

            borderWidth: 1
        }]
    };


    const config = {
        type: 'bar',
        data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    const pmonth = new Chart(document.getElementById('pmonth'),
        config);
    </script>

    <?php
include('commen/footer.php');
?>

    <script src="commen/script.js"></script>
</body>

</html>