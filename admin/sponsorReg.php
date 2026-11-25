<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';
require_once __DIR__ . '/../helpers/id_generator.php';

$m_id = generate_next_id($con, 'sponsors', 's_id', 'S');
$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sregister'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $s_id = generate_next_id($con, 'sponsors', 's_id', 'S');
        $f_name = clean_input($_POST['f_name'] ?? '');
        $l_name = clean_input($_POST['l_name'] ?? '');
        $contact = clean_input($_POST['contact'] ?? '');
        $email = clean_input($_POST['email'] ?? '');
        $company = clean_input($_POST['company'] ?? '');

        if ($f_name === '' || $l_name === '' || $contact === '' || $email === '' || $company === '') {
            $errorMsg = 'Please fill in all required fields.';
        } elseif (!is_valid_phone($contact)) {
            $errorMsg = 'Phone number must be exactly 10 digits.';
        } elseif (!is_valid_email($email)) {
            $errorMsg = 'Please enter a valid email address.';
        } else {
            $upload = handle_image_upload($_FILES['simage'] ?? [], __DIR__ . '/../images', 'images', true);
            if (!$upload['ok']) {
                $errorMsg = $upload['error'];
            } else {
                $imgPath = $upload['path'];
                $stmt = mysqli_prepare($con, 'INSERT INTO `sponsors` (`s_id`, `f_name`, `l_name`, `email`, `contact`, `company`, `image`) VALUES (?, ?, ?, ?, ?, ?, ?)');
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'sssssss', $s_id, $f_name, $l_name, $email, $contact, $company, $imgPath);
                    if (mysqli_stmt_execute($stmt)) {
                        $successMsg = 'Sponsor ' . $company . ' (' . $s_id . ') registered successfully.';
                        $m_id = generate_next_id($con, 'sponsors', 's_id', 'S');
                    } else {
                        $errorMsg = 'Failed to register sponsor.';
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
        <h1>Sponsor Registration</h1>
        <a href="sponsors.php" class="btn btn-secondary">Back to Sponsors</a>
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
                    <label class="labels" for="m_id">Sponsor ID</label>
                    <input type="text" id="m_id" name="m_id" value="<?php echo e($m_id); ?>" readonly>
                </div>
                <div class="input-box">
                    <label class="labels" for="company">Company Name</label>
                    <input type="text" id="company" name="company" placeholder="Enter company name" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="f_name">Contact First Name</label>
                    <input type="text" id="f_name" name="f_name" placeholder="First name" onkeyup="lettersOnly(this)" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="l_name">Contact Last Name</label>
                    <input type="text" id="l_name" name="l_name" placeholder="Last name" onkeyup="lettersOnly(this)" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="contact">Phone Number (10 digits)</label>
                    <input type="tel" id="contact" name="contact" placeholder="07XXXXXXXX" maxlength="10" pattern="[0-9]{10}" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="sponsor@company.com" required>
                </div>
                <div class="input-box full">
                    <label class="labels" for="simage">Company Logo</label>
                    <input type="file" id="simage" name="simage" accept="image/*" required>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="sregister" id="sregister">Register Sponsor</button>
                <a href="sponsors.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
