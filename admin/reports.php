<?php
include __DIR__ . '/header.php';

$cancerOptions = [];
$res = mysqli_query($con, 'SELECT `name` FROM `cancers` ORDER BY `name` ASC');
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $cancerOptions[] = $row['name'];
    }
}
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Excel Reports</h1>
    </div>
    <hr>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo e($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <div class="table_subtitle">
        <h3><ion-icon name="person-outline"></ion-icon> Patients by Cancer Type</h3>
        <div class="content_form">
            <form action="export.php" method="post">
                <?php echo csrf_field(); ?>
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels" for="cancer">Cancer Type</label>
                        <select id="cancer" name="cancer" required>
                            <option value="">Select cancer type...</option>
                            <?php foreach ($cancerOptions as $cname): ?>
                                <option value="<?php echo e($cname); ?>"><?php echo e($cname); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="button">
                    <button name="report_pa" type="submit" class="btn">
                        <ion-icon name="download-outline"></ion-icon>
                        <span>Export Filtered Patients (.xlsx)</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <hr style="margin:2rem 0;">

    <div class="table_subtitle">
        <h3><ion-icon name="cash-outline"></ion-icon> Donations by Category</h3>
        <div class="content_form">
            <form action="export.php" method="post">
                <?php echo csrf_field(); ?>
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels" for="status">Donation Category</label>
                        <select id="status" name="status" required>
                            <option value="all">All Donations</option>
                            <option value="member">Members</option>
                            <option value="patients">Patients</option>
                            <option value="sponsor">Sponsors</option>
                            <option value="New Hospital Building">New Hospital Building</option>
                            <option value="Pet Scan Machine">PET Scan Machine</option>
                        </select>
                    </div>
                </div>
                <div class="button">
                    <button name="report_do" type="submit" class="btn">
                        <ion-icon name="download-outline"></ion-icon>
                        <span>Export Donations (.xlsx)</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
