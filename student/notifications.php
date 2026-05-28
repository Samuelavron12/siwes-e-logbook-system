<?php
require_once 'header.php';
require_once '../config/db.php';

$user_id = $_SESSION['user_id'];

/* MARK AS READ */

$conn->query("
    UPDATE notifications
    SET is_read = 1
    WHERE user_id = '$user_id'
");

/* FETCH */

$query = $conn->query("
    SELECT * FROM notifications
    WHERE user_id = '$user_id'
    ORDER BY created_at DESC
");
?>

<div class="notification-container">

    <h2>Notifications</h2>

    <?php while($row = $query->fetch_assoc()): ?>

        <div class="notification-card">

            <p>
                <?php echo $row['message']; ?>
            </p>

            <small>
                <?php echo $row['created_at']; ?>
            </small>

        </div>

    <?php endwhile; ?>

</div>

<?php
require_once 'footer.php';
?>