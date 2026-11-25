<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';

$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event'])) {
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
            $upload = handle_image_upload($_FILES['eimage'] ?? [], __DIR__ . '/../imagee', 'imagee', true);
            if (!$upload['ok']) {
                $errorMsg = $upload['error'];
            } else {
                $imgPath = $upload['path'];
                $stmt = mysqli_prepare($con, 'INSERT INTO `event` (`title`, `location`, `description`, `image`, `date`) VALUES (?, ?, ?, ?, ?)');
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'sssss', $title, $location, $description, $imgPath, $date);
                    if (mysqli_stmt_execute($stmt)) {
                        $successMsg = 'Event added successfully.';
                    } else {
                        $errorMsg = 'Failed to add event.';
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
}

include __DIR__ . '/header.php';
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Add Event</h1>
        <a href="events.php" class="btn btn-secondary">Back to Events</a>
    </div>
    <hr>

    <?php if ($errorMsg !== ''): ?>
        <div class="alert alert-danger" role="alert"><?php echo e($errorMsg); ?></div>
    <?php endif; ?>
    <?php if ($successMsg !== ''): ?>
        <div class="alert alert-success" role="alert"><?php echo e($successMsg); ?></div>
    <?php endif; ?>

    <div class="content_form">
        <form method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="input-details">
                <div class="input-box">
                    <label class="labels" for="title">Event Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter event title" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="location">Location</label>
                    <input type="text" id="location" name="location" placeholder="Enter event location" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="eimage">Event Image</label>
                    <input type="file" id="eimage" name="eimage" accept="image/*" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="date">Event Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="input-box full">
                    <label class="labels" for="description">Description</label>
                    <textarea id="description" name="description" rows="6" placeholder="Enter event details" required></textarea>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="event" id="event">Add Event</button>
                <a href="events.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
=======
include('header.php');
include ('../db/db.php');
?>





<div class="container_admin">
    <div class="table_title">
        <h1>Add Event</h1>


    </div>
    <hr>
    <div class="" id="event_sign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Event added Successfully!
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">Title</label>
                        <input type="text" placeholder="Enter Title" required name="title">
                    </div>
                    <div class="input-box">
                        <label class="labels">Location</label>
                        <input type="text" placeholder="Enter location" required name="location">
                    </div>

                    <div class="input-box">
                        <label class="labels">Image</label>
                        <input type="file" placeholder="Enter Image" required name="eimage">
                    </div>
                    <div class="input-box">
                        <label class="labels">Date</label>
                        <input type="date" placeholder="Enter Description" required name="date">
                    </div>
                    <div class="input-box">
                        <label class="labels">Description</label>

                        <textarea rows="10" type="text" placeholder="Enter Description" required
                            name="description"></textarea>
                    </div>

                </div>

                <div class="button">
                    <input type="submit" class="btn" value="ADD" name="event" id="event">
                    <a href="events.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>

<?php 



if(isset($_POST["event"])){

$title = $_POST["title"];
$location = $_POST["location"];
$description = $_POST["description"];
$date = $_POST["date"];


$tm=md5 (time());
$image=$_FILES["eimage"]["name"];
$dst="../imagee/".$tm.$image;
$dst1="imagee/".$tm.$image;

move_uploaded_file($_FILES["eimage"]["tmp_name"],$dst);


if(empty($title) || empty($description) ){


    echo "
            <div class=' alert-warning' role='alert'>
            
                      <b>  Fill All Fields...</b>
            </div>

    ";
    exit();
}
else{

$sql = "INSERT INTO `event` (`id`, `title`, `location`, `description`, `image`, `date`) 
VALUES (NULL, '$title', '$title', '$description', '$dst1', '$date')";

        


$run_query = mysqli_query($con,$sql);
if($run_query){

            
?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location.href = window.location.href;
}, 2000);
</script>
<?php
        }
        
    
    }
    
    }
    

?>


<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
