<?php
include('header.php');

?>

<div class="container_admin">
    <div class="table_title">
        <h1>Donations</h1>


    </div>
    <hr>

    <!-- <div class="charts">
        <a href="d_chart.php" class="chart">
            <div>
                <h3>Membership Donations</h3>
            </div>
        </a>

        <a href="p_chart.php" class="chart">
            <div>
                <h3>Hospital Donations</h3>
            </div>
        </a>

        <a href="c_chart.php" class="chart">
            <div>
                <h3>Patients Donations</h3>
            </div>
        </a>

    </div> -->

    <div class="container_body">
        <div class="details_table">


            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Key</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>

                    </tr>
                </thead>
                <?php 
                $res=mysqli_query($con,"SELECT * FROM `donations`");
                while($row=mysqli_fetch_array($res))
                {
                ?>

                <tbody>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>

                        <td><?php echo $row["key_id"]; ?></td>
                        <td><?php echo number_format($row["amount"]) ?></td>
                        <td><?php echo $row["status"]; ?></td>
                        <td><?php echo $row["date"]; ?></td>

                    </tr>

                </tbody>

                <?php 
                }
                ?>

            </table>

        </div>

    </div>

</div>



<?php
include('footer.php');
?>