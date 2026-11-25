<?php
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/../db/db.php';
require_once __DIR__ . '/../helpers/validation.php';
require_once __DIR__ . '/../helpers/auth.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$salon = null;

if ($id && $id > 0) {
    $stmt = mysqli_prepare($con, 'SELECT * FROM `salons` WHERE `id` = ? LIMIT 1');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $salon = $res ? mysqli_fetch_assoc($res) : null;
        mysqli_stmt_close($stmt);
    }
}

$errorMsg = '';
$successMsg = '';

if ($salon && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['csrf_token'] ?? '')) {
        $errorMsg = 'Session expired. Please refresh and try again.';
    } elseif (isset($_POST['reset'])) {
        $resetHash = hash_user_password('123456');
        $updLogin = mysqli_prepare($con, "UPDATE `login` SET `password` = ? WHERE `uname` = ? AND `role` = 'salon'");
        if ($updLogin) {
            mysqli_stmt_bind_param($updLogin, 'ss', $resetHash, $salon['s_id']);
            if (mysqli_stmt_execute($updLogin)) {
                $successMsg = 'Salon password reset to default (123456).';
            } else {
                $errorMsg = 'Could not reset salon password.';
            }
            mysqli_stmt_close($updLogin);
        }
    } elseif (isset($_POST['editsalon'])) {
        $name = clean_input($_POST['name'] ?? '');
        $address = clean_input($_POST['address'] ?? '');
        $latRaw = clean_input($_POST['lat'] ?? '');
        $lngRaw = clean_input($_POST['lng'] ?? '');
        $email = clean_input($_POST['email'] ?? '');
        $lisence = clean_input($_POST['lisence'] ?? '');
        $contact = clean_input($_POST['contact'] ?? '');

        if ($name === '' || $address === '' || $latRaw === '' || $lngRaw === '' || $email === '' || $lisence === '' || $contact === '') {
            $errorMsg = 'Please fill in all required fields.';
        } elseif (!is_valid_coordinate($latRaw, -90.0, 90.0) || !is_valid_coordinate($lngRaw, -180.0, 180.0)) {
            $errorMsg = 'Please enter valid latitude and longitude values.';
        } elseif (!is_valid_phone($contact)) {
            $errorMsg = 'Contact number must be exactly 10 digits.';
        } elseif (!is_valid_email($email)) {
            $errorMsg = 'Please enter a valid email address.';
        } else {
            $lat = (float)$latRaw;
            $lng = (float)$lngRaw;
            $upd = mysqli_prepare($con, 'UPDATE `salons` SET `name` = ?, `address` = ?, `lat` = ?, `lng` = ?, `email` = ?, `lisence` = ?, `contact` = ? WHERE `id` = ?');
            if ($upd) {
                mysqli_stmt_bind_param($upd, 'ssddsssi', $name, $address, $lat, $lng, $email, $lisence, $contact, $id);
                if (mysqli_stmt_execute($upd)) {
                    $successMsg = 'Salon details updated successfully.';
                    $salon = array_merge($salon, [
                        'name' => $name,
                        'address' => $address,
                        'lat' => $lat,
                        'lng' => $lng,
                        'email' => $email,
                        'lisence' => $lisence,
                        'contact' => $contact,
                    ]);
                } else {
                    $errorMsg = 'Failed to update salon details.';
                }
                mysqli_stmt_close($upd);
            }
        }
    }
}

include __DIR__ . '/header.php';
?>

<div class="container_admin">
    <div class="table_title">
        <h1>Edit Partner Salon</h1>
        <div class="action-group">
            <?php if ($salon): ?>
                <form method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-outline" name="reset" type="submit">Reset Password</button>
                </form>
            <?php endif; ?>
            <a href="salons.php" class="btn btn-secondary">Back to Salons</a>
        </div>
    </div>
    <hr>

    <?php if (!$salon): ?>
        <div class="empty-state">
            <h3>Salon Not Found</h3>
            <p>The requested salon record does not exist.</p>
            <a href="salons.php" class="btn">Return to Salons</a>
        </div>
    <?php else: ?>
        <?php if ($errorMsg !== ''): ?>
            <div class="alert alert-danger" role="alert"><?php echo e($errorMsg); ?></div>
        <?php endif; ?>
        <?php if ($successMsg !== ''): ?>
            <div class="alert alert-success" role="alert"><?php echo e($successMsg); ?></div>
        <?php endif; ?>

        <div class="content_form">
            <form method="POST">
                <?php echo csrf_field(); ?>
                <div class="input-details">
                    <div class="input-box">
                        <label class="labels" for="s_id">Salon ID</label>
                        <input type="text" id="s_id" name="s_id" value="<?php echo e($salon['s_id']); ?>" readonly>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="name">Salon Name</label>
                        <input type="text" id="name" name="name" value="<?php echo e($salon['name']); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo e($salon['email']); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="lisence">License No</label>
                        <input type="text" id="lisence" name="lisence" value="<?php echo e($salon['lisence']); ?>" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="lat">Latitude</label>
                        <input type="number" id="lat" name="lat" value="<?php echo e((string)$salon['lat']); ?>" step="any" min="-90" max="90" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="lng">Longitude</label>
                        <input type="number" id="lng" name="lng" value="<?php echo e((string)$salon['lng']); ?>" step="any" min="-180" max="180" required>
                    </div>
                    <div class="input-box">
                        <label class="labels" for="contact">Contact</label>
                        <input type="tel" id="contact" name="contact" value="<?php echo e($salon['contact']); ?>" maxlength="10" pattern="[0-9]{10}" required>
                    </div>
                    <div class="input-box full">
                        <label class="labels" for="address">Address</label>
                        <textarea id="address" name="address" rows="3" required><?php echo e($salon['address']); ?></textarea>
                    </div>
                </div>

                <div class="button">
                    <button type="submit" class="btn" name="editsalon" id="editsalon">Save Changes</button>
                    <a href="salons.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
