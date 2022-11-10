<?php
include('header.php');
include ('../db/db.php');
?>

<script src="../db/main.js"></script>

<?php 

$sql_id = "SELECT * FROM `salons` order by id desc limit 1";
$res = mysqli_query($con, $sql_id);
 $row = mysqli_fetch_array($res);
 $lastid = $row['s_id'];

 if($lastid == " "){
   $m_id = "SL_1";
 }else{
   $m_id = substr($lastid,3);
   $m_id = intval($m_id);
   $m_id = "SL_" . ($m_id + 1);
 }


?>

<div class="container_admin">
    <div class="table_title">
        <h1>Add Salon</h1>


    </div>
    <hr>
    <div class="" id="salon_sign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Salon added Successfully!
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">ID</label>
                        <input type="text" placeholder="Enter Name" required name="s_id" value="<?php echo $m_id ?>"
                            readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels">Salon Name</label>
                        <input type="text" placeholder="Enter Name" required name="name">
                    </div>
                    <div class="input-box">
                        <label class="labels">Email</label>
                        <input type="email" placeholder="Enter Email" required name="email">
                    </div>
                    <div class="input-box">
                        <label class="labels">Lisence No</label>
                        <input type="text" placeholder="Enter Lisence No" required name="lisence">
                    </div>

                    <div class="input-box">
                        <label class="labels">Latitude</label>
                        <input type="number" placeholder="Enter Latitude" required name="lat">
                    </div>
                    <div class="input-box">
                        <label class="labels">Longtude</label>
                        <input type="number" placeholder="Enter Longtude" required name="lng">
                    </div>
                    <div class="input-box">
                        <label class="labels">Contact</label>
                        <input type="number" placeholder="Enter Mobile Number" required name="contact">
                    </div>
                    <div class="input-box">
                        <label class="labels">Address</label>
                        <textarea name="address" id="" rows="10" type="text" required
                            placeholder="Enter Address"></textarea>
                    </div>

                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Register" name="salon" id="salon">
                </div>
            </form>
        </div>

    </div>



</div>




<?php
include('footer.php');
?>