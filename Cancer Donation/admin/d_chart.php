<?php
include('header.php');
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Donations Charts</h1>


    </div>
    <hr>

    <div class="table_subtitle">
        <h3>Monthly Grow<ion-icon name="calendar-outline"></ion-icon>
        </h3>
        <hr>
    </div>




    <?php





$res=mysqli_query($con,"SELECT MONTHNAME(date) as mname, sum(amount) as total FROM donations GROUP BY MONTH(date)");
$amount = array();
$month = array();

                while($row=mysqli_fetch_array($res))
                {
                    
$amount[] = $row["total"];
$month[] = $row["mname"];

                }



                // ========================================

                $res=mysqli_query($con,"SELECT MONTHNAME(date) as mname1, COUNT(*) as row FROM patients GROUP BY MONTH(date)");
$amount1 = array();
$month1 = array();

                while($row=mysqli_fetch_array($res))
                {
                    
$amount1[] = $row["row"];
$month1[] = $row["mname1"];

                }


?>




    <div class="patient_month">

        <canvas id="donation"></canvas>

    </div>

    <!-- <div class="patient_month">

        <canvas id="donation1"></canvas>

    </div> -->


    <script>
    const amount = <?php echo json_encode($amount); ?>



    const data = {
        labels: <?php echo json_encode($month); ?>,
        datasets: [{
            label: <?php echo json_encode($month); ?>,
            data: amount,
            backgroundColor: [
                'rgba(190, 4, 4)',

            ],

            borderWidth: 1
        }]
    };


    const config = {
        type: 'bar',
        data,
        options: {
            responsive: true,
        }
    };



    const donation = new Chart(document.getElementById('donation'),
        config);


    //======================================================================================

    const amount1 = <?php echo json_encode($amount1); ?>

    const data1 = {
        labels: <?php echo json_encode($month1); ?>,
        datasets: [{
            label: '# of Votes',
            data: amount1,
            backgroundColor: [
                'rgba(190, 4, 4)',
            ],

            borderWidth: 1
        }]
    };

    const config1 = {
        type: 'bar',
        data: data1,
        options: {
            responsive: true,
        }
    };

    const donation1 = new Chart(document.getElementById('donation1'),
        config1);
    </script>



</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<?php
include('footer.php');
?>