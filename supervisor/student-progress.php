<?php

require_once 'header.php';
require_once '../config/db.php';

$supervisor_id = $_SESSION['user_id'];

$query = mysqli_query(

    $conn,

    "

    SELECT

        u.user_id,
        u.full_name,
        p.matric_no,
        p.department

    FROM student_supervisors ss

    JOIN users u
    ON ss.student_id = u.user_id

    LEFT JOIN student_profiles p
    ON ss.student_id = p.student_id

    WHERE ss.supervisor_id = '$supervisor_id'

    ORDER BY u.full_name ASC

    "

);

?>

<div class="progress-container">

    <h2>Student Progress Monitor</h2>

    <div class="progress-grid">

        <?php while($student = mysqli_fetch_assoc($query)): ?>

        <?php

        $student_id = $student['user_id'];

        // TOTAL LOGS

        $total_logs = mysqli_num_rows(

            mysqli_query(

                $conn,

                "

                SELECT id

                FROM log_entries

                WHERE student_id='$student_id'

                "

            )

        );

        // APPROVED

        $approved = mysqli_num_rows(

            mysqli_query(

                $conn,

                "

                SELECT id

                FROM log_entries

                WHERE student_id='$student_id'

                AND status='approved'

                "

            )

        );

        // REJECTED

        $rejected = mysqli_num_rows(

            mysqli_query(

                $conn,

                "

                SELECT id

                FROM log_entries

                WHERE student_id='$student_id'

                AND status='rejected'

                "

            )

        );

        // PENDING

        $pending = mysqli_num_rows(

            mysqli_query(

                $conn,

                "

                SELECT id

                FROM log_entries

                WHERE student_id='$student_id'

                AND status='pending'

                "

            )

        );

        // EVIDENCE

        $evidence = mysqli_num_rows(

            mysqli_query(

                $conn,

                "

                SELECT id

                FROM weekly_evidence

                WHERE student_id='$student_id'

                "

            )

        );

        ?>

        <div class="progress-card">

            <h3>
                <?php echo $student['full_name']; ?>
            </h3>

            <p>
                <?php echo $student['matric_no']; ?>
            </p>

            <p>
                <?php echo $student['department']; ?>
            </p>

            <hr>

            <div class="stats">

                <div>
                    <span>Total Logs</span>
                    <strong><?php echo $total_logs; ?></strong>
                </div>

                <div>
                    <span>Approved</span>
                    <strong class="approved">
                        <?php echo $approved; ?>
                    </strong>
                </div>

                <div>
                    <span>Rejected</span>
                    <strong class="rejected">
                        <?php echo $rejected; ?>
                    </strong>
                </div>

                <div>
                    <span>Pending</span>
                    <strong class="pending">
                        <?php echo $pending; ?>
                    </strong>
                </div>

                <div>
                    <span>Evidence</span>
                    <strong>
                        <?php echo $evidence; ?>
                    </strong>
                </div>

            </div>

            <?php

            $score = 0;

            if($total_logs > 0){

                $score = round(

                    ($approved / $total_logs) * 100

                );
            }

            ?>

            <div class="performance">

                <?php

                if($score >= 80){

                    echo "<span class='excellent'>
                    Excellent
                    </span>";

                }elseif($score >= 60){

                    echo "<span class='good'>
                    Good
                    </span>";

                }elseif($score >= 40){

                    echo "<span class='average'>
                    Average
                    </span>";

                }else{

                    echo "<span class='poor'>
                    Poor
                    </span>";
                }

                ?>

            </div>

        </div>

        <?php endwhile; ?>

    </div>

</div>

<?php require_once 'footer.php'; ?>