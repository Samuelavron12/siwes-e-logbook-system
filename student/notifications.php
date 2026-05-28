<?php
require_once 'header.php';
require_once '../config/db.php';

$user_id = $_SESSION['user_id'];

/* FETCH NOTIFICATIONS */

$query = mysqli_query(

    $conn,

    "

    SELECT *

    FROM notifications

    WHERE user_id = '$user_id'

    ORDER BY notification_id DESC

    "
);
?>

<div class="notification-container">

    <h2>Notifications</h2>

    <?php if(mysqli_num_rows($query) > 0): ?>

        <?php while($row = mysqli_fetch_assoc($query)): ?>

            <div class="notification-card">

                <p>
                    <?php echo $row['message']; ?>
                </p>

                <small>
                    <?php echo $row['created_at']; ?>
                </small>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <div class="notification-empty">

            No notifications available.

        </div>

    <?php endif; ?>

</div>

<?php
require_once 'footer.php';
?>