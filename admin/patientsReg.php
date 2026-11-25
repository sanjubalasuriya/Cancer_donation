<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';
require_once __DIR__ . '/../helpers/id_generator.php';

$m_id = generate_next_id($con, 'patients', 'p_id', 'P');
$errorMsg = '';
$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pregister'])) {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } else {
        $p_id = generate_next_id($con, 'patients', 'p_id', 'P');
        $f_name = clean_input($_POST['f_name'] ?? '');
        $l_name = clean_input($_POST['l_name'] ?? '');
        $nic = clean_input($_POST['nic'] ?? '');
        $contact = clean_input($_POST['contact'] ?? '');
        $email = clean_input($_POST['email'] ?? '');
        $dob = clean_input($_POST['dob'] ?? '');
        $gender = clean_input($_POST['gender'] ?? '');
        $cancer = clean_input($_POST['cancer'] ?? '');
        $c_step = clean_input($_POST['c_step'] ?? '');
        $amountRaw = clean_input($_POST['amount'] ?? '');
        $address = clean_input($_POST['address'] ?? '');

        if ($f_name === '' || $l_name === '' || $nic === '' || $contact === '' || $email === '' || $dob === '' || $gender === '' || $cancer === '' || $c_step === '' || $amountRaw === '' || $address === '') {
            $errorMsg = 'Please fill in all required fields.';
        } elseif (!is_valid_nic($nic)) {
            $errorMsg = 'Please enter a valid NIC number.';
        } elseif (!is_valid_phone($contact)) {
            $errorMsg = 'Mobile number must be exactly 10 digits.';
        } elseif (!is_valid_email($email)) {
            $errorMsg = 'Please enter a valid email address.';
        } elseif (!is_positive_number($amountRaw)) {
            $errorMsg = 'Target amount must be greater than zero.';
        } else {
            $upload = handle_image_upload($_FILES['pimage'] ?? [], __DIR__ . '/../image', 'image', true);
            if (!$upload['ok']) {
                $errorMsg = $upload['error'];
            } else {
                $amount = (int)$amountRaw;
                $donateZero = 0;
                $imgPath = $upload['path'];

                $stmt = mysqli_prepare(
                    $con,
                    'INSERT INTO `patients` (`p_id`, `f_name`, `l_name`, `nic`, `contact`, `email`, `dob`, `gender`, `cancer`, `c_step`, `amount`, `donate`, `address`, `image`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, 'ssssssssssiiss', $p_id, $f_name, $l_name, $nic, $contact, $email, $dob, $gender, $cancer, $c_step, $amount, $donateZero, $address, $imgPath);
                    if (mysqli_stmt_execute($stmt)) {
                        $successMsg = 'Patient ' . $p_id . ' registered successfully.';
                        $m_id = generate_next_id($con, 'patients', 'p_id', 'P');
                    } else {
                        $errorMsg = 'Could not register patient. Please try again.';
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $errorMsg = 'Unable to prepare patient registration query.';
                }
            }
        }
    }
}

include __DIR__ . '/header.php';

$cancerOptions = [];
$cRes = mysqli_query($con, 'SELECT `name` FROM `cancers` ORDER BY `name` ASC');
if ($cRes) {
    while ($cRow = mysqli_fetch_assoc($cRes)) {
        $cancerOptions[] = $cRow['name'];
    }
}
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Patient Registration</h1>
        <a href="patients.php" class="btn btn-secondary">Back to Patients</a>
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
                    <label class="labels" for="p_id">Patient ID</label>
                    <input type="text" id="p_id" name="p_id" value="<?php echo e($m_id); ?>" readonly>
                </div>
                <div class="input-box">
                    <label class="labels" for="f_name">First Name</label>
                    <input type="text" id="f_name" name="f_name" placeholder="Enter first name" onkeyup="lettersOnly(this)" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="l_name">Last Name</label>
                    <input type="text" id="l_name" name="l_name" placeholder="Enter last name" onkeyup="lettersOnly(this)" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="nic">NIC</label>
                    <input type="text" id="nic" name="nic" placeholder="e.g. 901711671V" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="contact">Phone Number (10 digits)</label>
                    <input type="tel" id="contact" name="contact" placeholder="07XXXXXXXX" maxlength="10" pattern="[0-9]{10}" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="patient@example.com" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" max="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select gender...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="input-box">
                    <label class="labels" for="cancer">Cancer Type</label>
                    <select id="cancer" name="cancer" required>
                        <option value="">Select cancer type...</option>
                        <?php foreach ($cancerOptions as $cname): ?>
                            <option value="<?php echo e($cname); ?>"><?php echo e($cname); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-box">
                    <label class="labels" for="c_step">Cancer Stage</label>
                    <select id="c_step" name="c_step" required>
                        <option value="">Select stage...</option>
                        <option value="Level 1">Level 1</option>
                        <option value="Level 2">Level 2</option>
                        <option value="Level 3">Level 3</option>
                        <option value="Level 4">Level 4</option>
                    </select>
                </div>
                <div class="input-box">
                    <label class="labels" for="amount">Target Amount (Rs.)</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter required treatment amount" min="1" step="1" required>
                </div>
                <div class="input-box">
                    <label class="labels" for="pimage">Patient Photo</label>
                    <input type="file" id="pimage" name="pimage" accept="image/*" required>
                </div>
                <div class="input-box full">
                    <label class="labels" for="address">Address</label>
                    <textarea id="address" name="address" rows="3" placeholder="Enter patient address" required></textarea>
                </div>
            </div>

            <div class="button">
                <button type="submit" class="btn" name="pregister" id="pregister">Register Patient</button>
                <a href="patients.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
