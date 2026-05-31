<?php
require_once 'header.php';
require_once '../config/db.php';

$id = $_GET['id'];

$query = $conn->query("
    SELECT * FROM log_entries
    WHERE id = '$id'
");

$row = $query->fetch_assoc();
?>

<!-------- body ----------->
<div class="form-container">
    <h2>Edit Log Entry</h2>
    <form action="update-log.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <!-- DATE -->
        <label>Log Date</label>
        <input type="date" name="log_date" value="<?php echo $row['log_date']; ?>" required>
        <!-- TITLE -->
        <label>Title</label>
        <input type="text" name="title" value="<?php echo $row['title']; ?>" required>
        <!-- ACTIVITY -->
        <label>Activity</label>
        <textarea name="activity" rows="5" required><?php echo $row['activity']; ?></textarea>
        <button type="submit" name="update_log"> Update Log </button>

    </form>

</div>

<?php
require_once 'footer.php';
?>