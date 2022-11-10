<?php
include('header.php');
include ('../db/db.php');
?>

<script src="../db/main.js"></script>

<?php 

$sql_id = "SELECT * FROM `cancers` order by id desc limit 1";
$res = mysqli_query($con, $sql_id);
 $row = mysqli_fetch_array($res);
 $lastid = $row['num'];

 if($lastid == " "){
   $m_id = "C1";
 }else{
   $m_id = substr($lastid,1);
   $m_id = intval($m_id);
   $m_id = "C" . ($m_id + 1);
 }


?>

<div class="container_admin">
    <div class="table_title">
        <h1>Cancer Register</h1>


    </div>
    <hr>
    <div class="" id="csign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Cancer Registerd Successfully!
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels"> ID</label>
                        <input type="text" placeholder="" required name="num" value="<?php echo $m_id;?>" readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels"> Name</label>
                        <input type="text" placeholder="Enter Cancer name" required name="name">
                    </div>
                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Register" name="cregister" id="cregister">
                    <a href="cancers.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>




<?php
include('footer.php');
?>