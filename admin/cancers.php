<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/admin_actions.php';

handle_admin_delete_request($con, 'cancers', 'Cancer type');

include __DIR__ . '/header.php';

$cancers = [];
$res = mysqli_query($con, 'SELECT `id`, `num`, `name` FROM `cancers` ORDER BY `id` ASC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $cancers[] = $row;
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
        <h1>Cancer Types</h1>
        <a href="cancerReg.php" class="btn">Add Cancer Type</a>
    </div>
    <hr>

    <?php if (empty($cancers)): ?>
        <div class="empty-state">
            <h3>No Cancer Categories Added</h3>
            <p>Add cancer types so they appear in patient registration and reporting filters.</p>
            <a href="cancerReg.php" class="btn">Add Cancer Type</a>
        </div>
    <?php else: ?>
        <div class="details_table">
=======
        <h1>Cancers</h1>
        <a href="cancerReg.php" class="btn">Register</a>

    </div>
    <hr>

    <div class="container_body">
        <div class="details_table">
            <div class="alert-success" id="success" style="display:none">
                Password Changed Successfully!
            </div>


>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
<<<<<<< HEAD
                        <th>Code</th>
                        <th>Cancer Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cancers as $row): ?>
                        <tr>
                            <td>#<?php echo (int)$row['id']; ?></td>
                            <td><strong><?php echo e($row['num']); ?></strong></td>
                            <td><?php echo e($row['name']); ?></td>
                            <td>
                                <div class="action-group">
                                    <a href="edit_cancer.php?id=<?php echo (int)$row['id']; ?>" class="action edit">Edit</a>
                                    <button type="button"
                                            class="action delete secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Delete Cancer Type?"
                                            data-text="This will remove <?php echo e($row['name']); ?>."
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
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
