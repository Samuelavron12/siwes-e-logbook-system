<?php
require_once 'header.php';
?>

<div class="form-container">

    <h2>Add Log Entry</h2>

    <form action="save-log.php" method="POST" enctype="multipart/form-data">

        <!-- DATE -->

        <label>Log Date</label>
        <input type="date" name="log_date" required>

        <!-- TITLE -->

        <label>Title</label>
        <input type="text" name="title" placeholder="enter title of the day" required>

        <!-- ACTIVITY -->

        <label>Activity Description</label>
        <textarea name="activity" rows="5"
                  placeholder="Describe what you did today..."
                  required></textarea>

        <!-- ATTACHMENT -->

        <label>Upload Evidence (optional)</label>
        <input type="file" name="attachment">

        <!-- SUBMIT -->

        <button type="submit" name="save_log">
            Submit Log
        </button>

    </form>

</div>

<?php
require_once 'footer.php';
?>