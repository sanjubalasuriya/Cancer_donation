<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';

$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $title = clean_input($_POST['title'] ?? '');
        $location = clean_input($_POST['location'] ?? '');
        $description = clean_input($_POST['description'] ?? '');
        $date = clean_input($_POST['date'] ?? '');

        if ($title === '' || $location === '' || $description === '' || $date === '') {
            $errorMsg = 'Please fill in all required fields.';
        } else {
            $upload = handle_image_upload($_FILES['eimage'] ?? [], __DIR__ . '/../imagee', 'imagee', true);
            if (!$upload['ok']) {
                $errorMsg = $upload['error'];
            } else {
                $imgPath = $upload['path'];
                $stmt = mysqli_prepare($con, 'INSERT INTO `event` (`title`, `location`, `description`, `image`, `date`) VALUES (?, ?, ?, ?, ?)');
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'sssss', $title, $location, $description, $imgPath, $date);
                    if (mysqli_stmt_execute($stmt)) {
                        $successMsg = 'Event added successfully.';
                    } else {
                        $errorMsg = 'Failed to add event.';
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
}

include __DIR__ . '/header.php';
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Add Event</h1>
        <a href="events.php" class="btn btn-secondary">Back to Events</a>
    </div>
    <hr>

    <?php if ($errorMsg !== ''): ?>
        <div class="alert alert-danger" role="alert"><?php echo e($errorMsg); ?></div>
    <?php endif; ?>
    <?php if ($successMsg !== ''): ?>
        <div class="alert alert-success" role="alert"><?php echo e($successMsg); ?></div>
    <?php endif; ?>

    <div class="content_form">
        <form method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="input-details">
                <div class="input-box">
                    <label class="labels" for="title">Event Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter event title" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="location">Location</label>
                    <input type="text" id="location" name="location" placeholder="Enter event location" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="eimage">Event Image</label>
                    <input type="file" id="eimage" name="eimage" accept="image/*" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="date">Event Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="input-box full">
                    <label class="labels" for="description">Description</label>
                    <textarea id="description" name="description" rows="6" placeholder="Enter event details" required></textarea>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="event" id="event">Add Event</button>
                <a href="events.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
