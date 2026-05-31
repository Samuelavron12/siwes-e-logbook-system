<?php

require_once 'header.php';
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];

/* GET FIRST LOG */

$first_log_query = mysqli_query(

    $conn,

    "

    SELECT log_date

    FROM log_entries

    WHERE student_id = '$student_id'

    ORDER BY log_date ASC

    LIMIT 1

    "

);

$first_log = mysqli_fetch_assoc($first_log_query);

if(!$first_log){

    echo "

    <div class='report-container'>

        <h2>SIWES Report</h2>

        <p>No logs uploaded yet.</p>

    </div>

    ";

    require_once 'footer.php';

    exit();
}

$start_date = strtotime($first_log['log_date']);

/* GET ALL LOGS */

$logs = mysqli_query(

    $conn,

    "

    SELECT *

    FROM log_entries

    WHERE student_id='$student_id'

    ORDER BY log_date ASC

    "

);

$current_week = 0;

?>

<div class="report-container">

<h2>SIWES Weekly Report</h2>

<a class="download-report-btn"

href="generate-report.php">

Download Complete SIWES Report

</a>

<?php

while($log = mysqli_fetch_assoc($logs)){

    $week_no = floor(

        (

            strtotime($log['log_date'])

            -

            $start_date

        )

        /

        (60*60*24*7)

    ) + 1;

    if($week_no != $current_week){

        if($current_week != 0){

            $evidence = mysqli_query(

                $conn,

                "

                SELECT *

                FROM weekly_evidence

                WHERE student_id='$student_id'

                AND week_no='$current_week'

                LIMIT 1

                "

            );

            if(mysqli_num_rows($evidence) > 0){

                $ev = mysqli_fetch_assoc($evidence);

?>

<div class="week-evidence">

    <h4>Weekly Evidence</h4>

<?php

$extension = strtolower(

    pathinfo(

        $ev['evidence_file'],

        PATHINFO_EXTENSION

    )

);

if($extension == 'pdf'){

?>

<a target="_blank"

href="../uploads/evidence/<?php echo $ev['evidence_file']; ?>">

View PDF Evidence

</a>

<?php

}else{

?>

<img

src="../uploads/evidence/<?php echo $ev['evidence_file']; ?>"

alt="Evidence">

<?php } ?>

</div>

<?php

            }

            echo "</div>";
        }

        $current_week = $week_no;

?>

<div class="week-card">

<h3>Week <?php echo $week_no; ?></h3>

<?php } ?>

<div class="day-entry">

    <div class="day-header">

        <span>

            <?php

            echo date(

                "l",

                strtotime($log['log_date'])

            );

            ?>

        </span>

        <small>

            <?php

            echo date(

                "d M Y",

                strtotime($log['log_date'])

            );

            ?>

        </small>

    </div>

    <h4>

        <?php echo $log['title']; ?>

    </h4>

    <p>

        <?php echo nl2br($log['activity']); ?>

    </p>

</div>

<?php } ?>

<?php

if($current_week > 0){

    $evidence = mysqli_query(

        $conn,

        "

        SELECT *

        FROM weekly_evidence

        WHERE student_id='$student_id'

        AND week_no='$current_week'

        LIMIT 1

        "

    );

    if(mysqli_num_rows($evidence) > 0){

        $ev = mysqli_fetch_assoc($evidence);

?>

<div class="week-evidence">

<h4>Weekly Evidence</h4>

<?php

$extension = strtolower(

    pathinfo(

        $ev['evidence_file'],

        PATHINFO_EXTENSION

    )

);

if($extension == 'pdf'){

?>

<a target="_blank"

href="../uploads/evidence/<?php echo $ev['evidence_file']; ?>">

View PDF Evidence

</a>

<?php } else { ?>

<img

src="../uploads/evidence/<?php echo $ev['evidence_file']; ?>"

alt="Evidence">

<?php } ?>

</div>

<?php

    }

    echo "</div>";
}

?>

</div>

<?php require_once 'footer.php'; ?>