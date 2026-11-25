<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';

$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['news'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $title = clean_input($_POST['title'] ?? '');
        $description = clean_input($_POST['description'] ?? '');

        if ($title === '' || $description === '') {
            $errorMsg = 'Please fill in both title and description.';
        } else {
            $upload = handle_image_upload($_FILES['nimage'] ?? [], __DIR__ . '/../imagen', 'imagen', true);
            if (!$upload['ok']) {
                $errorMsg = $upload['error'];
            } else {
                $imgPath = $upload['path'];
                $stmt = mysqli_prepare($con, 'INSERT INTO `news` (`title`, `image`, `description`) VALUES (?, ?, ?)');
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'sss', $title, $imgPath, $description);
                    if (mysqli_stmt_execute($stmt)) {
                        $successMsg = 'News article published successfully.';
                    } else {
                        $errorMsg = 'Failed to publish news article.';
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
        <h1>Add News Article</h1>
        <a href="newss.php" class="btn btn-secondary">Back to News</a>
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
                    <label class="labels" for="title">Headline</label>
                    <input type="text" id="title" name="title" placeholder="Enter news headline" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="nimage">Featured Image</label>
                    <input type="file" id="nimage" name="nimage" accept="image/*" required>
                </div>
                <div class="input-box full">
                    <label class="labels" for="description">Article Content</label>
                    <textarea id="description" name="description" rows="6" placeholder="Write the full news story" required></textarea>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="news" id="news">Publish News</button>
                <a href="newss.php" class="btn btn-secondary">Cancel</a>
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
        <h1>Add News</h1>


    </div>
    <hr>
    <div class="" id="news_sign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        News added Successfully!
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
                        <label class="labels">Image</label>
                        <input type="file" placeholder="Enter Image" required name="nimage">
                    </div>
                    <div class="input-box">
                        <label class="labels">Description</label>

                        <textarea cols="30" rows="10" type="text" placeholder="Enter Description" required
                            name="description"></textarea>
                    </div>


                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Register" name="news" id="news">
                    <a href="newss.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>

<?php 



if(isset($_POST["news"])){

$title = $_POST["title"];
$description = $_POST["description"];



$tm=md5 (time());
$image=$_FILES["nimage"]["name"];
$dst="../imagen/".$tm.$image;
$dst1="imagen/".$tm.$image;

move_uploaded_file($_FILES["nimage"]["tmp_name"],$dst);




$sql = "INSERT INTO `news` (`id`, `title`, `image`, `description` ) 
VALUES (NULL, '$title', '$dst1', '$description')";

        


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
    

?>


<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
