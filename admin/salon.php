<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/id_generator.php';

$m_id = generate_next_id($con, 'salons', 's_id', 'SL_');

include __DIR__ . '/header.php';
=======
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


>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
?>

<div class="container_admin">
    <div class="table_title">
<<<<<<< HEAD
        <h1>Register Partner Salon</h1>
        <a href="salons.php" class="btn btn-secondary">Back to Salons</a>
    </div>
    <hr>

    <div id="salon_sign"></div>

    <div class="content_form">
        <form method="POST" action="salonReg.php" id="salonForm">
            <?php echo csrf_field(); ?>
            <div class="input-details">
                <div class="input-box">
                    <label class="labels" for="s_id">Salon ID (Login Username)</label>
                    <input type="text" id="s_id" name="s_id" value="<?php echo e($m_id); ?>" readonly>
                </div>
                <div class="input-box">
                    <label class="labels" for="name">Salon Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter salon name" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="salon@example.com" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="lisence">License Number</label>
                    <input type="text" id="lisence" name="lisence" placeholder="Enter business license no." required>
                </div>
                <div class="input-box">
                    <label class="labels" for="lat">Latitude</label>
                    <input type="number" id="lat" name="lat" placeholder="e.g. 6.8482" step="any" min="-90" max="90" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="lng">Longitude</label>
                    <input type="number" id="lng" name="lng" placeholder="e.g. 79.9265" step="any" min="-180" max="180" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="contact">Contact Number (10 digits)</label>
                    <input type="tel" id="contact" name="contact" placeholder="011XXXXXXX" maxlength="10" pattern="[0-9]{10}" required>
                </div>
                <div class="input-box full">
                    <label class="labels" for="address">Address</label>
                    <textarea id="address" name="address" rows="3" placeholder="Enter full street address" required></textarea>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="salon" id="salonSubmitBtn">Register Salon</button>
                <a href="salons.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
jQuery(document).ready(function ($) {
    $("#salonForm").on("submit", function (e) {
        e.preventDefault();
        var $btn = $("#salonSubmitBtn");
        var orig = $btn.html();
        $btn.prop("disabled", true).html('<span class="spinner"></span> Registering...');

        $.ajax({
            url: "salonReg.php",
            method: "POST",
            dataType: "json",
            data: $(this).serialize(),
            success: function (res) {
                var ok = Boolean(res && res.ok);
                var msg = (res && res.message) || "Completed.";
                $("#salon_sign").html('<div class="alert ' + (ok ? "alert-success" : "alert-danger") + '">' + $("<div>").text(msg).html() + "</div>");
                swal({
                    title: ok ? "Success" : "Notice",
                    text: msg,
                    icon: ok ? "success" : "error"
                }).then(function () {
                    if (ok && res.redirect) window.location.href = res.redirect;
                });
            },
            error: function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) || "Failed to register salon.";
                $("#salon_sign").html('<div class="alert alert-danger">' + $("<div>").text(msg).html() + "</div>");
            },
            complete: function () {
                $btn.prop("disabled", false).html(orig);
            }
        });
    });
});
</script>

<?php include __DIR__ . '/footer.php'; ?>
=======
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
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
