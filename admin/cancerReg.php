<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/id_generator.php';

$m_id = generate_next_id($con, 'cancers', 'num', 'C');

include __DIR__ . '/header.php';
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Register Cancer Type</h1>
        <a href="cancers.php" class="btn btn-secondary">Back to Cancers</a>
    </div>
    <hr>

    <div id="csign"></div>

    <div class="content_form">
        <form method="POST" action="cregister.php">
            <?php echo csrf_field(); ?>
            <div class="input-details">
                <div class="input-box">
                    <label class="labels" for="num">Cancer Code</label>
                    <input type="text" id="num" name="num" value="<?php echo e($m_id); ?>" readonly>
                </div>
                <div class="input-box">
                    <label class="labels" for="name">Cancer Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter cancer name" required>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="cregister" id="cregister">Save Cancer Type</button>
                <a href="cancers.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>

<script src="../db/main.js"></script>
<?php include __DIR__ . '/footer.php'; ?>
