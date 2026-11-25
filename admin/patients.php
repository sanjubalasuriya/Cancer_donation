<?php
<<<<<<< HEAD
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/admin_actions.php';

handle_admin_delete_request($con, 'patients', 'Patient');

include __DIR__ . '/header.php';

$patients = [];
$res = mysqli_query($con, 'SELECT `id`, `p_id`, `f_name`, `l_name`, `contact`, `email`, `cancer`, `amount`, `donate`, `image` FROM `patients` ORDER BY `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $patients[] = $row;
    }
}
$csrf = csrf_token();
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Patients</h1>
        <a href="patientsReg.php" class="btn">Register Patient</a>
    </div>
    <hr>

    <div class="repot_table">
        <input type="text" id="searchBox-2" data-table-search="#table-2" placeholder="Search patients...">
        <form action="export.php" method="post">
            <?php echo csrf_field(); ?>
            <button name="patient_repo" type="submit" class="btn btn-secondary">
                <ion-icon class="report_icon" name="download-outline"></ion-icon>
                <span>Export Excel</span>
            </button>
        </form>
    </div>

    <?php if (empty($patients)): ?>
        <div class="empty-state">
            <h3>No Patients Registered</h3>
            <p>Add a patient record to begin tracking treatment funding and progress.</p>
            <a href="patientsReg.php" class="btn">Register Patient</a>
        </div>
    <?php else: ?>
        <div class="details_table">
=======
include('header.php');
include('../db/db.php');

?>



<div class="container_admin">
    <div class="table_title">
        <h1>Patients</h1>
        <a href="patientsReg.php" class="btn">Register</a>

    </div>
    <hr>

    <div class="container_body">
        <div class="details_table">
            <?php
                if(isset($_SESSION['error'])){
                    echo"
                    <div class='alert alert-danger'>
                    <h4>error!</h4>
                    ".$_SESSION['error']."
                    </div>
                    ";
                    unset($_SESSION['error']);
                }

                if(isset($_SESSION['success'])){
                    echo"
                    <div class='alert alert-success'>
                    <h4>Success!</h4>
                    ".$_SESSION['success']."
                    </div>
                    ";
                    unset($_SESSION['success']);

                }
                ?>
            <div class="repot_table">
                <input type="text" id="searchBox-2" placeholder="Search Here">
                <form action="export.php" method="post">

                    <button name="patient_repo" type="submit" class="btn ">
                        Export <ion-icon class="report_icon" name="document-outline"></ion-icon>
                        <ion-icon class="report_icon" name="download-outline">
                        </ion-icon>
                    </button>
                </form>
            </div>


>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
            <table id="table-2">
                <thead>
                    <tr>
                        <th>ID</th>
<<<<<<< HEAD
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Cancer</th>
                        <th>Funding</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $row): ?>
                        <tr>
                            <td><strong><?php echo e($row['p_id']); ?></strong></td>
                            <td>
                                <img class="table-thumb" src="../<?php echo e($row['image'] ?: 'img/patients1.jpg'); ?>" alt="<?php echo e($row['f_name']); ?>">
                            </td>
                            <td><?php echo e($row['f_name'] . ' ' . $row['l_name']); ?></td>
                            <td><?php echo e($row['contact']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td><?php echo e($row['cancer']); ?></td>
                            <td>Rs. <?php echo number_format((int)$row['donate']); ?> / <?php echo number_format((int)$row['amount']); ?></td>
                            <td>
                                <div class="action-group">
                                    <a href="edit_patient.php?id=<?php echo (int)$row['id']; ?>" class="action edit">Edit</a>
                                    <button type="button"
                                            class="action delete secondary js-confirm-action"
                                            data-id="<?php echo (int)$row['id']; ?>"
                                            data-csrf="<?php echo e($csrf); ?>"
                                            data-title="Delete Patient?"
                                            data-text="This will permanently remove <?php echo e($row['f_name'] . ' ' . $row['l_name']); ?>."
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
                        <th>Patient</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Cancer</th>
                        <th class="col2">Action</th>

                    </tr>
                </thead>
                <?php 
                $res=mysqli_query($con,"SELECT * FROM `patients`");
                while($row=mysqli_fetch_array($res))
                {
                ?>

                <tbody>
                    <tr>
                        <td><?php echo $row["p_id"]; ?></td>
                        <td> <img src="../<?php echo $row["image"]; ?>" width="50px;" heigth="50px;" alt="image">
                        </td>
                        <td><?php echo $row["f_name"]; ?></td>
                        <td><?php echo $row["l_name"]; ?></td>
                        <td><?php echo $row["contact"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["cancer"]; ?></td>
                        <td class="col"><a href="edit_patient.php?id=<?php echo $row["id"]; ?>"
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
<!-- ================Search========================= -->
<script>
var searchBox_2 = document.getElementById("searchBox-2");
searchBox_2.addEventListener("keyup", function() {
    var keyword = this.value;
    keyword = keyword.toUpperCase();
    var table_2 = document.getElementById("table-2");
    var all_tr = table_2.getElementsByTagName("tr");
    for (var i = 0; i < all_tr.length; i++) {
        var id_column = all_tr[i].getElementsByTagName("td")[0];
        var fname_column = all_tr[i].getElementsByTagName("td")[2];
        var lname_column = all_tr[i].getElementsByTagName("td")[3];
        var email_column = all_tr[i].getElementsByTagName("td")[5];
        var cancer_column = all_tr[i].getElementsByTagName("td")[6];


        if (fname_column && lname_column) {
            var id_value = id_column.textContent || id_column.innerText;
            var fname_value = fname_column.textContent || fname_column.innerText;
            var lname_value = lname_column.textContent || lname_column.innerText;
            var email_value = email_column.textContent || email_column.innerText;
            var cancer_value = cancer_column.textContent || cancer_column.innerText;

            id_value = id_value.toUpperCase();
            fname_value = fname_value.toUpperCase();
            lname_value = lname_value.toUpperCase();
            email_value = email_value.toUpperCase();
            cancer_value = cancer_value.toUpperCase();

            if ((id_value.indexOf(keyword) > -1) || (fname_value.indexOf(keyword) > -1) || (lname_value
                    .indexOf(keyword) > -1) || (email_value
                    .indexOf(keyword) > -1) || (cancer_value.indexOf(keyword) > -1)) {
                all_tr[i].style.display = ""; // show
            } else {
                all_tr[i].style.display = "none"; // hide
            }
        }
    }
})
</script>
<!-- ================DELTE========================= -->
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

                            swal("Patient Delete Successfully.!", {
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

      $reg_query = "DELETE FROM `patients` WHERE id='$del_id'";
      $reg_query_run = mysqli_query($con, $reg_query);
  }
?>


<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
