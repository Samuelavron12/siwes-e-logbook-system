<?php

require_once 'header.php';
require_once '../config/db.php';

$supervisor_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| MARK ALL AS READ
|--------------------------------------------------------------------------
*/

if(isset($_GET['read_all']))
{

    mysqli_query(

        $conn,

        "

        UPDATE notifications

        SET is_read='1'

        WHERE user_id='$supervisor_id'

        "

    );

    header("Location: notifications.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| FETCH NOTIFICATIONS
|--------------------------------------------------------------------------
*/

$notifications = mysqli_query(

    $conn,

    "

    SELECT *

    FROM notifications

    WHERE user_id='$supervisor_id'

    ORDER BY created_at DESC

    "

);

?>

<div class="notifications-page">

<div class="notification-header">

    <h2>Notifications</h2>

    <a

    href="?read_all=1"

    class="mark-btn">

        Mark All Read

    </a>

</div>

<?php

if(mysqli_num_rows($notifications) > 0):

?>

    <?php

    while(

        $notification =
        mysqli_fetch_assoc($notifications)

    ):

    ?>

    <div

    class="notification-card

    <?php

    echo

    $notification['is_read']

    ? 'read'

    : 'unread';

    ?>">

        <div class="notification-message">

            <?php

            echo

            $notification['message'];

            ?>

        </div>

        <div class="notification-time">

            <?php

            echo date(

                'd M Y h:i A',

                strtotime(

                    $notification['created_at']

                )

            );

            ?>

        </div>

    </div>

    <?php endwhile; ?>

<?php else: ?>

    <div class="empty-notification">

        No Notifications Yet

    </div>

<?php endif; ?>

</div>

<?php require_once 'footer.php'; ?>
