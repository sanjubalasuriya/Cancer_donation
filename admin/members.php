<?php
<<<<<<< HEAD
include __DIR__ . '/header.php';

$members = [];
$res = mysqli_query($con, 'SELECT `m_id`, `f_name`, `l_name`, `contact`, `email`, `nic`, `status`, `date` FROM `members` ORDER BY `id` DESC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $members[] = $row;
    }
}
=======
include('header.php');

>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Members</h1>
<<<<<<< HEAD
    </div>
    <hr>

    <div class="repot_table">
        <input type="text" id="searchBox-2" data-table-search="#table-2" placeholder="Search members...">
        <form action="export.php" method="post">
            <?php echo csrf_field(); ?>
            <button name="members_repo" type="submit" class="btn btn-secondary">
                <ion-icon class="report_icon" name="download-outline"></ion-icon>
                <span>Export Excel</span>
            </button>
        </form>
    </div>

    <?php if (empty($members)): ?>
        <div class="empty-state">
            <h3>No Members Registered Yet</h3>
            <p>Members who register via the public portal will appear here.</p>
        </div>
    <?php else: ?>
        <div class="details_table">
=======


    </div>
    <hr>

    <div>
        <h3>All Members</h3>
    </div>

    <div class="container_body">
        <div class="details_table">
            <div class="repot_table"><input type="text" id="searchBox-2" placeholder="Search Here">
                <form action="export.php" method="post">

                    <button name="members_repo" type="submit" class="btn ">
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
                        <th>Name</th>
                        <th>NIC</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $row): ?>
                        <tr>
                            <td><strong><?php echo e($row['m_id']); ?></strong></td>
                            <td><?php echo e($row['f_name'] . ' ' . $row['l_name']); ?></td>
                            <td><?php echo e($row['nic']); ?></td>
                            <td><?php echo e($row['contact']); ?></td>
                            <td><?php echo e($row['email']); ?></td>
                            <td>
                                <span class="badge <?php echo strtolower((string)$row['status']) === 'paid' ? 'badge-success' : 'badge-neutral'; ?>">
                                    <?php echo e($row['status']); ?>
                                </span>
                            </td>
                            <td><?php echo e($row['date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
=======
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <?php 
                $res=mysqli_query($con,"SELECT * FROM `members` ");
                while($row=mysqli_fetch_array($res))
                {
                ?>

                <tbody>
                    <tr>
                        <td><?php echo $row["m_id"]; ?></td>
                        <td><?php echo $row["f_name"]; ?></td>
                        <td><?php echo $row["l_name"]; ?></td>
                        <td><?php echo $row["contact"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["status"]; ?></td>

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
var searchBox_2 = document.getElementById("searchBox-2");
searchBox_2.addEventListener("keyup", function() {
    var keyword = this.value;
    keyword = keyword.toUpperCase();
    var table_2 = document.getElementById("table-2");
    var all_tr = table_2.getElementsByTagName("tr");
    for (var i = 0; i < all_tr.length; i++) {
        var id_column = all_tr[i].getElementsByTagName("td")[0];
        var fname_column = all_tr[i].getElementsByTagName("td")[1];
        var lname_column = all_tr[i].getElementsByTagName("td")[2];
        var email_column = all_tr[i].getElementsByTagName("td")[4];



        if (fname_column && lname_column) {
            var id_value = id_column.textContent || id_column.innerText;
            var fname_value = fname_column.textContent || fname_column.innerText;
            var lname_value = lname_column.textContent || lname_column.innerText;
            var email_value = email_column.textContent || email_column.innerText;


            id_value = id_value.toUpperCase();
            fname_value = fname_value.toUpperCase();
            lname_value = lname_value.toUpperCase();
            email_value = email_value.toUpperCase();


            if ((id_value.indexOf(keyword) > -1) || (fname_value.indexOf(keyword) > -1) || (lname_value
                    .indexOf(keyword) > -1) || (email_value
                    .indexOf(keyword) > -1)) {
                all_tr[i].style.display = ""; // show
            } else {
                all_tr[i].style.display = "none"; // hide
            }
        }
    }
})
</script>

<?php
include('footer.php');
?>
>>>>>>> 3b14633bcb1afb9bdc3a4eb22f8cbe0fd8abce2e
