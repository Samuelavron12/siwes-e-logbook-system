

<?php

require_once 'header.php';
require_once '../config/db.php';

$supervisor_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| ANALYTICS
|--------------------------------------------------------------------------
*/

$student_query = mysqli_query(

    $conn,

    "

    SELECT COUNT(*) total

    FROM student_supervisors

    WHERE supervisor_id='$supervisor_id'

    "

);

$total_students =
mysqli_fetch_assoc($student_query)['total'];



$pending_query = mysqli_query(

    $conn,

    "

    SELECT COUNT(*) total

    FROM log_entries l

    INNER JOIN student_supervisors ss

    ON l.student_id = ss.student_id

    WHERE

    ss.supervisor_id='$supervisor_id'

    AND

    l.status='pending'

    "

);

$total_pending =
mysqli_fetch_assoc($pending_query)['total'];



$approved_query = mysqli_query(

    $conn,

    "

    SELECT COUNT(*) total

    FROM log_entries l

    INNER JOIN student_supervisors ss

    ON l.student_id = ss.student_id

    WHERE

    ss.supervisor_id='$supervisor_id'

    AND

    l.status='approved'

    "

);

$total_approved =
mysqli_fetch_assoc($approved_query)['total'];



$evidence_query = mysqli_query(

    $conn,

    "

    SELECT COUNT(*) total

    FROM weekly_evidence w

    INNER JOIN student_supervisors ss

    ON w.student_id = ss.student_id

    WHERE ss.supervisor_id='$supervisor_id'

    "

);

$total_evidence =
mysqli_fetch_assoc($evidence_query)['total'];



$message_query = mysqli_query(

    $conn,

    "

    SELECT COUNT(*) total

    FROM messages

    WHERE

    receiver_id='$supervisor_id'

    AND

    is_read='0'

    "

);

$total_messages =
mysqli_fetch_assoc($message_query)['total'];

?>

<div class="dashboard-header">

```
<div class="welcome-section">

    <h2>

        Welcome,
        <?php echo $_SESSION['full_name']; ?>

    </h2>

    <p>

        SIWES E-Logbook Supervisory Dashboard

    </p>

</div>

<div class="datetime-section">

    <p id="day"></p>

    <p id="date"></p>

    <h3 id="clock"></h3>

</div>

</div>

<div class="analytics-grid">

<div class="analytics-card">

    <h4>Assigned Students</h4>

    <h1>

        <?php echo $total_students; ?>

    </h1>

</div>

<div class="analytics-card">

    <h4>Pending Logs</h4>

    <h1>

        <?php echo $total_pending; ?>

    </h1>

</div>

<div class="analytics-card">

    <h4>Approved Logs</h4>

    <h1>

        <?php echo $total_approved; ?>

    </h1>

</div>

<div class="analytics-card">

    <h4>Weekly Evidence</h4>

    <h1>

        <?php echo $total_evidence; ?>

    </h1>

</div>

<div class="analytics-card">

    <h4>Unread Messages</h4>

    <h1>

        <?php echo $total_messages; ?>

    </h1>

</div>


</div>

<div class="dashboard-grid">


<div class="dashboard-panel">

    <h3>Student Progress</h3>

    <?php

    $progress = mysqli_query(

        $conn,

        "

        SELECT

            u.full_name,

            COUNT(l.id) total_logs

        FROM student_supervisors ss

        INNER JOIN users u
        ON ss.student_id = u.user_id

        LEFT JOIN log_entries l
        ON u.user_id = l.student_id

        WHERE ss.supervisor_id='$supervisor_id'

        GROUP BY u.user_id

        ORDER BY total_logs DESC

        "

    );

    while($row = mysqli_fetch_assoc($progress)):

    $percent = min(
        100,
        round(($row['total_logs'] / 120) * 100)
    );

    ?>

    <div class="student-progress">

        <div class="student-name">

            <?php echo $row['full_name']; ?>

        </div>

        <div class="progress-bar">

            <div

            class="progress-fill"

            style="width:<?php echo $percent; ?>%">

            </div>

        </div>

        <span>

            <?php echo $percent; ?>%

        </span>

    </div>

    <?php endwhile; ?>

</div>


<div class="dashboard-panel">

    <h3>Recent Log Activities</h3>

    <?php

    $activity = mysqli_query(

        $conn,

        "

        SELECT

            u.full_name,
            l.log_date,
            l.title

        FROM log_entries l

        INNER JOIN users u
        ON l.student_id = u.user_id

        INNER JOIN student_supervisors ss
        ON u.user_id = ss.student_id

        WHERE ss.supervisor_id='$supervisor_id'

        ORDER BY l.created_at DESC

        LIMIT 10

        "

    );

    while($row = mysqli_fetch_assoc($activity)):

    ?>

    <div class="activity-item">

        <strong>

            <?php echo $row['full_name']; ?>

        </strong>

        <br>

        <?php echo $row['title']; ?>

        <br>

        <small>

            <?php echo $row['log_date']; ?>

        </small>

    </div>

    <?php endwhile; ?>

</div>


</div>

<script>

function updateDateTime(){

    const now = new Date();

    document.getElementById('day')
    .innerHTML =
    now.toLocaleDateString(
        'en-US',
        { weekday:'long' }
    );

    document.getElementById('date')
    .innerHTML =
    now.toLocaleDateString();

    document.getElementById('clock')
    .innerHTML =
    now.toLocaleTimeString();
}

setInterval(updateDateTime,1000);

updateDateTime();

</script>

<?php require_once 'footer.php'; ?>

