<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$article = null;

if ($id && $id > 0) {
    $stmt = mysqli_prepare($con, 'SELECT * FROM `news` WHERE `id` = ? LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $article = $res ? mysqli_fetch_assoc($res) : null;
        mysqli_stmt_close($stmt);
    }
}

$errorMsg = '';
$successMsg = '';

if ($article && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['news'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $title = clean_input($_POST['title'] ?? '');
        $description = clean_input($_POST['description'] ?? '');

        if ($title === '' || $description === '') {
            $errorMsg = 'Please fill in both title and description.';
        } else {
            $upload = handle_image_upload($_FILES['nimage'] ?? [], __DIR__ . '/../imagen', 'imagen', false);
            if (!$upload['ok']) {
                $errorMsg = $upload['error'];
            } else {
                $newImg = $upload['path'] ?: $article['image'];
                $upd = mysqli_prepare($con, 'UPDATE `news` SET `title` = ?, `image` = ?, `description` = ? WHERE `id` = ?');
                if ($upd) {
                    mysqli_stmt_bind_param($upd, 'sssi', $title, $newImg, $description, $id);
                    if (mysqli_stmt_execute($upd)) {
                        $successMsg = 'News article updated successfully.';
                        $article = array_merge($article, [
                            'title' => $title,
                            'image' => $newImg,
                            'description' => $description,
                        ]);
                    } else {
                        $errorMsg = 'Failed to update news article.';
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
        <h1>Edit News</h1>
        <a href="newss.php" class="btn btn-secondary">Back to News</a>
    </div>
    <hr>

    <?php if (!$article): ?>
        <div class="empty-state">
            <h3>Article Not Found</h3>
            <p>The requested news article does not exist.</p>
            <a href="newss.php" class="btn">Return to News</a>
        </div>
    <?php else: ?>
        <?php if ($errorMsg !== ''): ?>
            <div class="alert alert-danger" role="alert"><?php echo e($errorMsg); ?></div>
        <?php endif; ?>
        <?php if ($successMsg !== ''): ?>
            <div class="alert alert-success" role="alert"><?php echo e($successMsg); ?></div>
        <?php endif; ?>

        <img class="preview-avatar" src="../<?php echo e($article['image']); ?>" alt="<?php echo e($article['title']); ?>">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels" for="title">Title</label>
                        <input type="text" id="title" name="title" value="<?php echo e($article['title']); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="nimage">Replace Image (optional)</label>
                        <input type="file" id="nimage" name="nimage" accept="image/*">
                    </div>
                    <div class="input-box full">
                        <label class="labels" for="description">Description</label>
                        <textarea id="description" name="description" rows="6" required><?php echo e($article['description']); ?></textarea>
                    </div>
                </div>

                <div class="button">
                    <button type="submit" class="btn" name="news" id="news">Save Changes</button>
                    <a href="newss.php" class="btn btn-secondary">Back</a>
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
$description="";



$res=mysqli_query($con,"SELECT * FROM `news` WHERE id=$id");  
while($row=mysqli_fetch_array($res))
{
    
    $title=$row["title"];
    $image=$row["image"];
    $description=$row["description"];
    
    
    
}


?>





<div class="container_admin">
    <div class="table_title">
        <h1>Update News</h1>


    </div>
    <hr>
    <div class="" id="news_sign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        News Updated Successfully!
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
                        <label class="labels">Image</label>
                        <input type="file" placeholder="Enter Image" name="nimage" value="<?php echo $image;?>">
                    </div>

                    <div class="input-box">
                        <label class="labels">Description</label>

                        <textarea type="text" placeholder="Enter Description" required name="description"
                            rows="10"><?php echo $description;?></textarea>
                    </div>


                </div>

                <div class="button">
                    <input type="submit" class="btn" value="Update" name="news" id="news">
                    <a href="newss.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>



</div>

<?php
if(isset($_POST["news"]))

{

    $tm=md5 (time());
    $image=$_FILES["nimage"]["name"];
    $dst="../imagen/".$tm.$image;
    $dst1="imagen/".$tm.$image;

    move_uploaded_file($_FILES["nimage"]["tmp_name"],$dst);

    if(empty($image) ){
        
        mysqli_query($con,"UPDATE `news` SET title='$_POST[title]', description='$_POST[description]' WHERE id=$id") or die(mysqli_error($con)); 
     
     ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "newss.php";
}, 1000);
</script>
<?php

exit();
    }

else{



    mysqli_query($con,"UPDATE `news` SET title='$_POST[title]', description='$_POST[description]', image='$dst1' WHERE id=$id") or die(mysqli_error($con)); 

    ?>
<script type="text/javascript">
document.getElementById("success").style.display = "block";
setTimeout(function() {
    window.location = "newss.php";
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
