<?php
include('header.php');
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Reports</h1>

    </div>
    <hr>
    <?php
                if(isset($_SESSION['error'])){
                    echo"
                    <div class='alert alert-danger'>
                    <h4>error!</h4>
                    ".$_SESSION['error']."
                    </div>
                    ";
                    unset($_SESSION['error']);
                }

                if(isset($_SESSION['success'])){
                    echo"
                    <div class='alert alert-success'>
                    <h4>Success!</h4>
                    ".$_SESSION['success']."
                    </div>
                    ";
                    unset($_SESSION['success']);

                }
                ?>
    <div class="table_subtitle">
        <h3>Patients Filter Data sheet<ion-icon name="calendar-outline"></ion-icon>
        </h3>
        <hr>



        <div class="content_form">
            <form action="export.php" method="post">
                <div class="input-details">
                    <div class="input-box">
                        <?php 
                
                $sql = "SELECT * FROM `cancers` ";
                $res = mysqli_query($con, $sql);

               
            
                ?>
                        <label class="labels">Cancer</label>
                        <select name="cancer" id="" required>
                            <option value="">Select</option>
                            <?php while($rows = mysqli_fetch_array($res)){
                            ?>
                            <option value="<?php echo $rows['name']; ?>"><?php echo $rows['name'] ?></option>
                            <?php

                            }?>
                        </select>
                    </div>

                </div>

                <div class="button">


                    <button name="report_pa" type="submit" class="btn ">
                        Export <ion-icon class="report_icon" name="document-outline"></ion-icon>
                        <ion-icon class="report_pa" name="download-outline">
                        </ion-icon>
                    </button>
                </div>
            </form>
        </div>


    </div>

    <!-- <div class="table_subtitle">
        <h3>Donation Filter Data sheet<ion-icon name="calendar-outline"></ion-icon>
        </h3>
        <hr>



        <div class="content_form">
            <form action="export.php" method="post">
                <div class="input-details">
                    <div class="input-box">

                        <label class="labels">Cancer</label>
                        <select name="status" id="" >
                            <option value="">Select</option>
                            <option value="member">Members</option>
                            <option value="patients">Patients</option>
                            <option value="sponsor">Sponsor</option>
                            <option value="New Hospital Building">New Hospital Building</option>
                            <option value="Pet Sacn Machine">Pet Scan Machine</option>



                        </select>
                    </div>

                </div>

                <div class="button">


                    <button name="report_do" type="submit" class="btn ">
                        Export <ion-icon class="report_icon" name="document-outline"></ion-icon>
                        <ion-icon class="report_do" name="download-outline">
                        </ion-icon>
                    </button>
                </div>
            </form>
        </div>


    </div> -->

    <!-- <div class="table_subtitle">
        <h3>Monthly Grow<ion-icon name="calendar-outline"></ion-icon>
        </h3>
        <hr>



        <div class="content_form">
            <form action="export.php" method="post">
                <div class="input-details">
                    <div class="input-box">
                        <?php 
                
                $sql = "SELECT * FROM `cancers` ";
                $res = mysqli_query($con, $sql);

               
            
                ?>
                        <label class="labels">Cancer</label>
                        <select name="cancer" id="">
                            <option value="">Select</option>
                            <?php while($rows = mysqli_fetch_array($res)){
                            ?>
                            <option value="<?php echo $rows['name']; ?>"><?php echo $rows['name'] ?></option>
                            <?php

                            }?>
                        </select>
                    </div>

                </div>

                <div class="button">


                    <button name="" type="submit" class="btn ">
                        Export <ion-icon class="report_icon" name="document-outline"></ion-icon>
                        <ion-icon class="report_icon" name="download-outline">
                        </ion-icon>
                    </button>
                </div>
            </form>
        </div>


    </div> -->



</div>



<?php
include('footer.php');
?>