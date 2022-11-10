<?php
include('header.php');
include ('../db/db.php');


$sql_id = "SELECT * FROM `sponsors` order by id desc limit 1";
$res = mysqli_query($con, $sql_id);
 $row = mysqli_fetch_array($res);
 $lastid = $row['s_id'];

 if($lastid == " "){
   $m_id = "S1";
 }else{
   $m_id = substr($lastid,1);
   $m_id = intval($m_id);
   $m_id = "S" . ($m_id + 1);
 }

?>




<div class="container_admin">
    <div class="table_title">
        <h1>Sponsor Register</h1>

    </div>
    <hr>
    <div class="" id="ssign">

    </div>
    <div class="alert-success" id="success" style="display:none">
        Sponsor added Successfully!
    </div>

    <div class="">

        <div class="content_form">
            <form method="POST" enctype="multipart/form-data">
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels">ID</label>
                        <input type="text" placeholder="Enter First name" required name="m_id"
                            value="<?php echo $m_id;?>" readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels">First Name</label>
                        <input type="text" placeholder="Enter First name" required name="f_name"
                            onkeyup="lettersOnly(this)" required>
                    </div>
                    <div class="input-box">
                        <label class="labels">Last Name</label>
                        <input type="text" placeholder="Enter Last Name" name="l_name" onkeyup="lettersOnly(this)"
                            required>
                    </div>
                    <div class="input-box">
                        <label class="labels">Phone Number</label>
                        <input type="number" placeholder="Enter Patient number" name="contact" required>
                    </div>
                    <div class="input-box">
                        <label class="labels">Email</label>
                        <input type="email" placeholder="Enter Patient Email" name="email" required>
                    </div>
                    <div class="input-box">
                        <label class="labels">Company</label>
                        <input type="text" placeholder="Enter Company Name" name="company" required>
                    </div>
                    <div class="input-box">
                        <label class="labels">Images</label>
                        <input type="file" placeholder="Enter Patient password" name="simage" required>
                    </div>

                </div>

                <div class="button">

                    <input type="submit" class="btn" value="Register" name="sregister" id="sregister">
                    <a href="sponsors.php" class="btn">Back</a>
                </div>
            </form>
        </div>

    </div>


</div>

<?php 



if(isset($_POST["sregister"])){



$m_id = $_POST["m_id"];
$f_name = $_POST["f_name"];
$l_name = $_POST["l_name"];
$contact = $_POST["contact"];
$email = $_POST["email"];
$company = $_POST["company"];



$tm=md5 (time());
$image=$_FILES["simage"]["name"];
$dst="../images/".$tm.$image;
$dst1="images/".$tm.$image;

move_uploaded_file($_FILES["simage"]["tmp_name"],$dst);




$sql = "INSERT INTO `sponsors` (`id`, `s_id`, `f_name`, `l_name`, `email`, `contact`, `company`,  `image`) 
VALUES (NULL, '$m_id', '$f_name', '$l_name', '$email', '$contact', '$company', '$dst1')";

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