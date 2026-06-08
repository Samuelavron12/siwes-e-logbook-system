<?php

require_once 'header.php';
require_once '../config/db.php';

$id = $_GET['id'];

$query = mysqli_query(

    $conn,

    "

    SELECT

        le.*,

        u.full_name,

        sp.matric_no

    FROM log_entries le

    INNER JOIN users u

    ON le.student_id = u.user_id

    LEFT JOIN student_profiles sp

    ON le.student_id = sp.student_id

    WHERE le.id='$id'

    "

);

$log = mysqli_fetch_assoc($query);

?>

<div class="log-view">

    <h2>

        <?php echo $log['full_name']; ?>

    </h2>

    <p>

        <strong>Matric No:</strong>

        <?php echo $log['matric_no']; ?>

    </p>

    <hr>

    <div class="log-detail">

        <label>Date</label>

        <p>

            <?php echo $log['log_date']; ?>

        </p>

    </div>

    <div class="log-detail">

        <label>Day</label>

        <p>

            <?php echo date('l',strtotime($log['log_date'])); ?>

        </p>

    </div>

    <div class="log-detail">

        <label>Title</label>

        <p>

            <?php echo $log['title']; ?>

        </p>

    </div>

    <div class="log-detail">

        <label>Activity</label>

        <p>

            <?php echo nl2br($log['activity']); ?>

        </p>

    </div>

    <div class="log-detail">

        <label>Status</label>

        <p>

            <?php echo ucfirst($log['status']); ?>

        </p>

    </div>

    <div class="log-detail">

        <label>Supervisor Comment</label>

        <p>

            <?php

            echo !empty($log['supervisor_comment'])

            ?

            nl2br($log['supervisor_comment'])

            :

            'No Comment';

            ?>

        </p>

    </div>

</div>

<?php require_once 'footer.php'; ?>