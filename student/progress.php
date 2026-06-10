<?php

require_once 'header.php';
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];

$profile = mysqli_num_rows(

    mysqli_query(

        $conn,

        "

        SELECT *

        FROM student_profiles

        WHERE student_id='$student_id'

        "

    )

);

$logs = mysqli_num_rows(

    mysqli_query(

        $conn,

        "

        SELECT *

        FROM log_entries

        WHERE student_id='$student_id'

        "

    )

);

$evidence = mysqli_num_rows(

    mysqli_query(

        $conn,

        "

        SELECT *

        FROM weekly_evidence

        WHERE student_id='$student_id'

        "

    )

);

$supervisor = mysqli_num_rows(

    mysqli_query(

        $conn,

        "

        SELECT *

        FROM student_supervisors

        WHERE student_id='$student_id'

        "

    )

);

$evaluation = mysqli_num_rows(

    mysqli_query(

        $conn,

        "

        SELECT *

        FROM evaluations

        WHERE student_id='$student_id'

        "

    )

);

$progress = 0;

if($profile) $progress += 20;
if($logs >= 5) $progress += 20;
if($evidence >= 5) $progress += 20;
if($supervisor) $progress += 20;
if($evaluation) $progress += 20;

?>

<div class="progress-page">

    <h2>SIWES Completion Status</h2>

    <div class="progress-card">

        <div class="progress-bar">

            <div

            class="progress-fill"

            style="width:<?php echo $progress; ?>%">

            </div>

        </div>

        <h3>

            <?php echo $progress; ?>%

            Completed

        </h3>

    </div>

    <div class="progress-checklist">

        <p>

            <?php echo $profile ? '✅' : '❌'; ?>

            Profile Completed

        </p>

        <p>

            <?php echo $logs >= 5 ? '✅' : '❌'; ?>

            Log Entries Submitted

        </p>

        <p>

            <?php echo $evidence >= 5 ? '✅' : '❌'; ?>

            Weekly Evidence Uploaded

        </p>

        <p>

            <?php echo $supervisor ? '✅' : '❌'; ?>

            Supervisor Assigned

        </p>

        <p>

            <?php echo $evaluation ? '✅' : '❌'; ?>

            Evaluation Completed

        </p>

    </div>

</div>

<?php require_once 'footer.php'; ?>