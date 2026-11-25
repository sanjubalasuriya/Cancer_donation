<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/admin_actions.php';

handle_admin_delete_request($con, 'news', 'News article');

include __DIR__ . '/header.php';

$newsList = [];
$res = mysqli_query($con, 'SELECT `id`, `title`, `image`, `description`, `date` FROM `news` ORDER BY `date` DESC, `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $newsList[] = $row;
    }
}
$csrf = csrf_token();
?>

<div class="container_admin">
    <div class="table_title">
        <h1>News</h1>
        <a href="news.php" class="btn">Add News</a>
    </div>
    <hr>

    <?php if (empty($newsList)): ?>
        <div class="empty-state">
            <h3>No News Articles</h3>
            <p>Publish foundation news and updates for visitors.</p>
            <a href="news.php" class="btn">Add News</a>
        </div>
    <?php else: ?>
        <div class="details_table">
=======
include('header.php');
include('../db/db.php');
?>



<div class="container_admin">
    <div class="table_title">
        <h1>News</h1>
        <a href="news.php" class="btn">Register</a>

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
<<<<<<< HEAD
                        <th>Summary</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newsList as $row): ?>
                        <tr>
                            <td><img class="table-thumb" src="../<?php echo e($row['image']); ?>" alt="<?php echo e($row['title']); ?>"></td>
                            <td><strong><?php echo e($row['title']); ?></strong></td>
                            <td><?php echo e(mb_strimwidth((string)$row['description'], 0, 90, '...')); ?></td>
                            <td><?php echo e($row['date']); ?></td>
                            <td>
                                <div class="action-group">
                                    <a href="edit_news.php?id=<?php echo (int)$row['id']; ?>" class="action edit">Edit</a>
                                    <button type="button"
                                            class="action delete secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Delete News Article?"
                                            data-text="This will remove <?php echo e($row['title']); ?>."
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
                        <th>Description</th>
                        <th>Date</th>
                        <th>Action</th>


                    </tr>
                </thead>
                <?php 
                $res=mysqli_query($con,"SELECT * FROM `news`");
                while($row=mysqli_fetch_array($res))
                {
                ?>

                <tbody>
                    <tr>
                        <td> <img src="../<?php echo $row["image"]; ?>" width="50px;" heigth="50px;" alt="image">
                        </td>
                        <td><?php echo $row["title"]; ?></td>
                        <td><?php echo $row["description"]; ?></td>
                        <td><?php echo $row["date"]; ?></td>

                        <td><a href="edit_news.php?id=<?php echo $row["id"]; ?>" class="action edit">Edit</a><input
                                type="hidden" class="delete_id_value" value="<?php echo $row["id"]; ?>">
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

      $reg_query = "DELETE FROM `news` WHERE id='$del_id'";
      $reg_query_run = mysqli_query($con, $reg_query);
  }
?>


<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
