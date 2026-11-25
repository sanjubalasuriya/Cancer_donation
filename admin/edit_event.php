<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$eventItem = null;

if ($id && $id > 0) {
    $stmt = mysqli_prepare($con, 'SELECT * FROM `event` WHERE `id` = ? LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $eventItem = $res ? mysqli_fetch_assoc($res) : null;
        mysqli_stmt_close($stmt);
    }
}

$errorMsg = '';
$successMsg = '';

if ($eventItem && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event1'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $title = clean_input($_POST['title'] ?? '');
        $location = clean_input($_POST['location'] ?? '');
        $description = clean_input($_POST['description'] ?? '');
        $date = clean_input($_POST['date'] ?? '');

        if ($title === '' || $location === '' || $description === '' || $date === '') {
            $errorMsg = 'Please fill in all required fields.';
        } else {
            $upload = handle_image_upload($_FILES['eimage'] ?? [], __DIR__ . '/../imagee', 'imagee', false);
            if (!$upload['ok']) {
                $errorMsg = $upload['error'];
            } else {
                $newImg = $upload['path'] ?: $eventItem['image'];
                $upd = mysqli_prepare($con, 'UPDATE `event` SET `title` = ?, `location` = ?, `image` = ?, `description` = ?, `date` = ? WHERE `id` = ?');
                if ($upd) {
                    mysqli_stmt_bind_param($upd, 'sssssi', $title, $location, $newImg, $description, $date, $id);
                    if (mysqli_stmt_execute($upd)) {
                        $successMsg = 'Event updated successfully.';
                        $eventItem = array_merge($eventItem, [
                            'title' => $title,
                            'location' => $location,
                            'image' => $newImg,
                            'description' => $description,
                            'date' => $date,
                        ]);
                    } else {
                        $errorMsg = 'Failed to update event.';
                    }
                    mysqli_stmt_close($upd);
                }
            }
        }
    }
}

include __DIR__ . '/header.php';
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Edit Event</h1>
        <a href="events.php" class="btn btn-secondary">Back to Events</a>
    </div>
    <hr>

    <?php if (!$eventItem): ?>
        <div class="empty-state">
            <h3>Event Not Found</h3>
            <p>The requested event record does not exist.</p>
            <a href="events.php" class="btn">Return to Events</a>
        </div>
    <?php else: ?>
        <?php if ($errorMsg !== ''): ?>
            <div class="alert alert-danger" role="alert"><?php echo e($errorMsg); ?></div>
        <?php endif; ?>
        <?php if ($successMsg !== ''): ?>
            <div class="alert alert-success" role="alert"><?php echo e($successMsg); ?></div>
        <?php endif; ?>

        <img class="preview-avatar" src="../<?php echo e($eventItem['image']); ?>" alt="<?php echo e($eventItem['title']); ?>">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels" for="title">Title</label>
                        <input type="text" id="title" name="title" value="<?php echo e($eventItem['title']); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="location">Location</label>
                        <input type="text" id="location" name="location" value="<?php echo e($eventItem['location']); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="eimage">Replace Image (optional)</label>
                        <input type="file" id="eimage" name="eimage" accept="image/*">
                    </div>
                    <div class="input-box">
                        <label class="labels" for="date">Date</label>
                        <input type="date" id="date" name="date" value="<?php echo e($eventItem['date']); ?>" required>
                    </div>
                    <div class="input-box full">
                        <label class="labels" for="description">Description</label>
                        <textarea id="description" name="description" rows="6" required><?php echo e($eventItem['description']); ?></textarea>
                    </div>
                </div>

                <div class="button">
                    <button type="submit" class="btn" name="event1" id="event">Save Changes</button>
                    <a href="events.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
=======
include('header.php');
include ('../db/db.php');



$id=$_GET["id"];
$title="";
$image="";
$location="";

$description="";
$date="";



$res=mysqli_query($con,"SELECT * FROM `event` WHERE id=$id");  
while($row=mysqli_fetch_array($res))
{
    
    $title=$row["title"];
    $image=$row["image"];
    $description=$row["description"];
    $location=$row["location"];
    $date=$row["date"];
    
    
    
}

?>





<div class="container_admin">
    <div class="table_title">
        <h1>Update Event</h1>


    </div>
    <hr>
    <div class="" id="event_sign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Event Updated Successfully!
    </div>
    <div>
        <center><img src="../<?php echo $image; ?>" width="250;" heigth="250;" alt="image"></center>
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">Title</label>
                        <input type="text" placeholder="Enter Title" required name="title" value="<?php echo $title;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Location</label>
                        <input type="text" placeholder="Enter location" required name="location"
                            value="<?php echo $location;?>">
                    </div>

                    <div class="input-box">
                        <label class="labels">Image</label>
                        <input type="file" placeholder="Enter Image" name="eimage" value="<?php echo $image;?>">
                    </div>
                    <div class="input-box">
                        <label class="labels">Date</label>
                        <input type="date" placeholder="Enter Description" required name="date"
                            value="<?php echo $date;?>">
                    </div>
                    <div class="input-box">

                        <label class="labels">Description</label>

                        <textarea rows="10" required name="description"><?php echo $description;?></textarea>
                    </div>

                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Update" name="event1" id="event">
                    <a href="events.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>

<?php
if(isset($_POST["event1"]))

{

    $tm=md5 (time());
    $image=$_FILES["eimage"]["name"];
    $dst="../imagee/".$tm.$image;
    $dst1="imagee/".$tm.$image;

    move_uploaded_file($_FILES["eimage"]["tmp_name"],$dst);

    if(empty($image) ){
        
        mysqli_query($con,"UPDATE `event` SET title='$_POST[title]', location='$_POST[location]', description='$_POST[description]', date='$_POST[date]'  WHERE id='$id'") or die(mysqli_error($con)); 
     
     ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "events.php";
}, 1000);
</script>
<?php

exit();
    }

else{



    mysqli_query($con,"UPDATE `event` SET title='$_POST[title]', location='$_POST[location]',image='$dst1', description='$_POST[description]', date='$_POST[date]'  WHERE id='$id'") or die(mysqli_error($con)); 

    ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "events.php";
}, 1000);
</script>
<?php

}
 }



?>


<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
