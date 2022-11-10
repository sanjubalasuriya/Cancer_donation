<?php
include('header.php');
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Patients Charts</h1>

    </div>
    <hr>

    <div class="table_subtitle">
        <h3>Patients Monthly increase<ion-icon name="calendar-outline"></ion-icon>
        </h3>
        <hr>
    </div>



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


    <script>
    const amount = <?php echo json_encode($amount); ?>

    const data = {
        labels: <?php echo json_encode($month); ?>,
        datasets: [{
            label: <?php echo json_encode($month); ?>,
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</div>



<?php
include('footer.php');
?>