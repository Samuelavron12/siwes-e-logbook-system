<?php

require_once 'header.php';
require_once '../config/db.php';

$query = mysqli_query(

    $conn,

    "

    SELECT *

    FROM admin_notifications

    ORDER BY notification_id DESC

    "

);

?>

<div class="notification-page">

    <h2>System Notifications</h2>

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

</div>

<?php require_once 'footer.php'; ?>