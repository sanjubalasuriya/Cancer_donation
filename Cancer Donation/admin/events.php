<?php
include('header.php');
include('../db/db.php');
?>



<div class="container_admin">
    <div class="table_title">
        <h1>Events</h1>
        <a href="event.php" class="btn">Register</a>

    </div>
    <hr>

    <div class="container_body">
        <div class="details_table">


            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Place</th>
                        <th>Date</th>
                        <th>Action</th>


                    </tr>
                </thead>
                <?php 
                $res=mysqli_query($con,"SELECT * FROM `event`");
                while($row=mysqli_fetch_array($res))
                {
                ?>

                <tbody>
                    <tr>
                        <td> <img src="../<?php echo $row["image"]; ?>" width="50px;" heigth="50px;" alt="image">
                        </td>
                        <td><?php echo $row["title"]; ?></td>
                        <td><?php echo $row["description"]; ?></td>
                        <td><?php echo $row["location"]; ?></td>
                        <td><?php echo $row["date"]; ?></td>

                        <td><a href="edit_event.php?id=<?php echo $row["id"]; ?>" class="action edit">Edit</a>

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

                                swal("Supplier Delete Successfully.!", {
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


</div>




<?php
include('footer.php');
?>