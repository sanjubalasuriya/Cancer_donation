<?php
include('header.php');
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Cancers</h1>
        <a href="cancerReg.php" class="btn">Register</a>

    </div>
    <hr>

    <div class="container_body">
        <div class="details_table">
            <div class="alert-success" id="success" style="display:none">
                Password Changed Successfully!
            </div>


            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Num</th>
                        <th>Cancer</th>
                        <th class="col2">Edit</th>



                    </tr>
                </thead>
                <?php 
                $res=mysqli_query($con,"SELECT * FROM `cancers`");
                while($row=mysqli_fetch_array($res))
                {
                ?>

                <tbody>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["num"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>

                        <td class="col"><a href="edit_cancer.php?id=<?php echo $row["id"]; ?>"
                                class="action edit">Edit</a>
                            <input type="hidden" class="delete_id_value" value="<?php echo $row["id"]; ?>">
                            <a href="javascripit:void(0)" class="delete_btn_ajax action edit">Delete</a>
                        </td>


                    </tr>

                </tbody>

                <?php 
                }
                ?>

            </table>

        </div>

    </div>

</div>

<script>
$(document).ready(function() {

    $('.delete_btn_ajax').click(function(e) {
        e.preventDefault();
        var deleteid = $(this).closest("tr").find('.delete_id_value').val();
        //console.log(deleteid);


        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        type: "POST",
                        url: "",
                        data: {
                            "delete_btn_set": 1,
                            "delete_id": deleteid,
                        },

                        success: function(response) {

                            swal("Cancer Delete Successfully.!", {
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });
                }
            });
    });

});
</script>


<?php
 
  if(isset($_POST['delete_btn_set']))

  {
      $del_id = $_POST['delete_id'];

      $reg_query = "DELETE FROM `event` WHERE id='$del_id'";
      $reg_query_run = mysqli_query($con, $reg_query);
  }
?>

<?php
include('footer.php');
?>