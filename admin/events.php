<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/admin_actions.php';

handle_admin_delete_request($con, 'event', 'Event');

include __DIR__ . '/header.php';

$events = [];
$res = mysqli_query($con, 'SELECT `id`, `title`, `location`, `image`, `description`, `date` FROM `event` ORDER BY `date` DESC, `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $events[] = $row;
    }
}
$csrf = csrf_token();
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Events</h1>
        <a href="event.php" class="btn">Add Event</a>
    </div>
    <hr>

    <?php if (empty($events)): ?>
        <div class="empty-state">
            <h3>No Events Created</h3>
            <p>Create awareness or fundraising events to display on the public website.</p>
            <a href="event.php" class="btn">Add Event</a>
        </div>
    <?php else: ?>
        <div class="details_table">
=======
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


>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
<<<<<<< HEAD
                        <th>Location</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $row): ?>
                        <tr>
                            <td><img class="table-thumb" src="../<?php echo e($row['image']); ?>" alt="<?php echo e($row['title']); ?>"></td>
                            <td><strong><?php echo e($row['title']); ?></strong></td>
                            <td><?php echo e(mb_strimwidth((string)$row['description'], 0, 90, '...')); ?></td>
                            <td><?php echo e($row['location']); ?></td>
                            <td><?php echo e($row['date']); ?></td>
                            <td>
                                <div class="action-group">
                                    <a href="edit_event.php?id=<?php echo (int)$row['id']; ?>" class="action edit">Edit</a>
                                    <button type="button"
                                            class="action delete secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Delete Event?"
                                            data-text="This will permanently delete <?php echo e($row['title']); ?>."
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
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
