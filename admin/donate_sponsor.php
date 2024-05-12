<?php
include('header.php');
include ('../db/db.php');




?>
<?php

$id=$_GET["id"];
$s_id="";





    


$res=mysqli_query($con,"SELECT * FROM `sponsors` WHERE id=$id");  
while($row=mysqli_fetch_array($res))
{
    $s_id=$row["s_id"];
    
    
    
    
    
    
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
                            value="<?php echo $s_id;?>" readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels">Amount</label>
                        <input type="number" placeholder="Enter Amount" required name="amount" required>
                    </div>


                </div>

                <div class="button">

                    <input type="submit" class="btn" value="Donate" name="dregister" id="dregister">
                    <a href="sponsors.php" class="btn">Back</a>
                </div>
            </form>


        </div>

    </div>




</div>

<?php 
                    $res=mysqli_query($con,"SELECT * FROM `donations` WHERE key_id ='$s_id'");

                    while($row=mysqli_fetch_array($res))
                    {
    
                    ?>

<div class="container_admin">
    <div class="table_title">
        <h1>Records</h1>


    </div>
    <hr>

    <div class="container_body">
        <div class="details_table">



            <table id="table-2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>Date</th>

                    </tr>
                </thead>


                <tbody>
                    <tr>

                        <td><?php echo $row["key_id"]; ?></td>
                        <td><?php echo $row["status"]; ?></td>
                        <td><?php echo $row["amount"]; ?></td>
                        <td><?php echo $row["date"]; ?></td>


                    </tr>

                </tbody>

                <?php 

                

                ?>
            </table>

        </div>

    </div>

</div>

<?php 

                    }

if(isset($_POST["dregister"])){



$m_id = $_POST["m_id"];
$amount = $_POST["amount"];





$sql = "INSERT INTO `donations` (`id`, `key_id`, `status`, `amount`) 
VALUES (NULL, '$m_id', 'sponsor', '$amount')";

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