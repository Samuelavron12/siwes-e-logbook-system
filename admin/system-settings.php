<?php

require_once 'header.php';
require_once '../config/db.php';

if(isset($_POST['save'])){

    $weeks = $_POST['weeks'];

    $logs = $_POST['logs'];

    $size = $_POST['size'];

    $types = $_POST['types'];

    mysqli_query(

        $conn,

        "

        UPDATE system_settings

        SET

        siwes_duration_weeks='$weeks',

        required_logs='$logs',

        max_upload_size='$size',

        allowed_file_types='$types'

        WHERE setting_id='1'

        "

    );

    $success = "Settings Updated Successfully";
}

$settings = mysqli_fetch_assoc(

    mysqli_query(

        $conn,

        "

        SELECT *

        FROM system_settings

        LIMIT 1

        "

    )

);

?>

<div class="settings-page">

    <h2>System Settings</h2>

    <?php if(isset($success)): ?>

    <div class="success-box">

        <?php echo $success; ?>

    </div>

    <?php endif; ?>

    <form method="POST">

        <div class="form-group">

            <label>SIWES Duration (Weeks)</label>

            <input
            type="number"
            name="weeks"
            value="<?php echo $settings['siwes_duration_weeks']; ?>">
        </div>

        <div class="form-group">

            <label>Required Logs</label>

            <input
            type="number"
            name="logs"
            value="<?php echo $settings['required_logs']; ?>">
        </div>

        <div class="form-group">

            <label>Max Upload Size (MB)</label>

            <input
            type="number"
            name="size"
            value="<?php echo $settings['max_upload_size']; ?>">
        </div>

        <div class="form-group">

            <label>Allowed File Types</label>

            <input
            type="text"
            name="types"
            value="<?php echo isset($settings['allowed_file_types']) ? $settings['allowed_file_types'] : ''; ?>">
        </div>

        <button
        type="submit"
        name="save">

            Save Settings

        </button>

    </form>

</div>

<?php require_once 'footer.php'; ?>