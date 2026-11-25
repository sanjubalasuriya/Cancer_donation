<?php
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
            <table id="table-2">
                <thead>
                    <tr>
                        <th>ID</th>
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
