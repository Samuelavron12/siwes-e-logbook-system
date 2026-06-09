<?php

require_once 'header.php';
require_once '../config/db.php';

$query = mysqli_query(

    $conn,

    "

    SELECT *

    FROM announcements

    WHERE

    target='supervisor'

    OR

    target='all'

    ORDER BY announcement_id DESC

    "

);

?>

<div class="announcements-page">

    <h2>Announcements</h2>

    <?php if(mysqli_num_rows($query) == 0): ?>

        <div class="empty-box">

            No announcements available.

        </div>

    <?php endif; ?>

    <?php while($row = mysqli_fetch_assoc($query)): ?>

        <div class="announcement-card">

            <div class="announcement-header">

                <h3>

                    <?php echo $row['title']; ?>

                </h3>

                <span>

                    <?php echo date(

                        "d M Y",

                        strtotime($row['created_at'])

                    ); ?>

                </span>

            </div>

            <div class="announcement-body">

                <?php echo nl2br($row['message']); ?>

            </div>

        </div>

    <?php endwhile; ?>

</div>

<?php require_once 'footer.php'; ?>