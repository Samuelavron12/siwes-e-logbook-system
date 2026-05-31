<?php
require_once 'header.php';
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];
?>

<div class="evidence-container">

    <h2>Upload Weekly Evidence</h2>
    <?php if(isset($_GET['error'])): ?>
    <div class="error-message">
        Evidence already exists for this week.
    </div>

    <?php endif; ?>

    <form action="save-evidence.php"
          method="POST"
          enctype="multipart/form-data">

        <label>Week Number</label>

        <select name="week_no" required>

            <option value="">Select Week</option>

            <?php for($i=1; $i<=24; $i++): ?>

                <option value="<?php echo $i; ?>">
                    Week <?php echo $i; ?>
                </option>

            <?php endfor; ?>

        </select>

        <label>Evidence Title</label>

        <input type="text"
               name="title"
               required>

        <label>Description</label>

        <textarea name="description"
                  rows="4"></textarea>

        <label>Upload Image/File</label>

        <input
        type="file"
        name="evidence_file"
        accept=".jpg,.jpeg,.png,.pdf"
        required>

        <button type="submit"
                name="upload_evidence">

            Upload Evidence

        </button>

    </form>

</div>

<?php
require_once 'footer.php';
?>