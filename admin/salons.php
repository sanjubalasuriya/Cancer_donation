<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/admin_actions.php';

handle_admin_delete_request($con, 'salons', 'Salon');

include __DIR__ . '/header.php';

$salons = [];
$res = mysqli_query($con, 'SELECT `id`, `s_id`, `name`, `address`, `contact`, `email` FROM `salons` ORDER BY `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $salons[] = $row;
    }
}
$csrf = csrf_token();
=======
include('header.php');
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
?>

<div class="container_admin">
    <div class="table_title">
<<<<<<< HEAD
        <h1>Partner Salons</h1>
        <a href="salon.php" class="btn">Register Salon</a>
    </div>
    <hr>

    <?php if (empty($salons)): ?>
        <div class="empty-state">
            <h3>No Partner Salons Registered</h3>
            <p>Add hair-donation partner salons so donors can locate them on the map.</p>
            <a href="salon.php" class="btn">Register Salon</a>
        </div>
    <?php else: ?>
        <div class="details_table">
=======
        <h1>Salons</h1>
        <a href="salon.php" class="btn">Register</a>

    </div>
    <hr>

    <div class="container_body">
        <div class="details_table">


>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
<<<<<<< HEAD
                        <th>Salon Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salons as $row): ?>
                        <tr>
                            <td><strong><?php echo e($row['s_id']); ?></strong></td>
                            <td><?php echo e($row['name']); ?></td>
                            <td><?php echo e($row['address']); ?></td>
                            <td><?php echo e($row['contact']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td>
                                <div class="action-group">
                                    <a href="edit_salon.php?id=<?php echo (int)$row['id']; ?>" class="action edit">Edit</a>
                                    <button type="button"
                                            class="action delete secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Delete Salon?"
                                            data-text="This will also remove the salon's portal login account."
                                            data-confirm-text="Delete">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
=======
                        <th>Name</th>
                        <th>Address</th>
                        <th>Action</th>


                    </tr>
                </thead>
                <?php 
                $res=mysqli_query($con,"SELECT * FROM `salons`");
                while($row=mysqli_fetch_array($res))
                {
                ?>

                <tbody>
                    <tr>
                        <td><?php echo $row["s_id"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["address"]; ?></td>

                        <td><a href="edit_salon.php?id=<?php echo $row["id"]; ?>" class="action edit">Edit</a>
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

                            swal("Salon Delete Successfully.!", {
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

      $reg_query = "DELETE FROM `salons` WHERE id='$del_id'";
      $reg_query_run = mysqli_query($con, $reg_query);
  }
?>



<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
