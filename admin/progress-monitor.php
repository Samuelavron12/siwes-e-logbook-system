<?php

require_once 'header.php';
require_once '../config/db.php';

$query = mysqli_query(

    $conn,

    "

    SELECT

        u.user_id,
        u.full_name,

        sp.matric_no,
        sp.department,

        (
            SELECT COUNT(*)

            FROM log_entries

            WHERE student_id = u.user_id

        ) AS total_logs,

        (
            SELECT COUNT(*)

            FROM weekly_evidence

            WHERE student_id = u.user_id

        ) AS total_evidence

    FROM users u

    LEFT JOIN student_profiles sp

    ON u.user_id = sp.student_id

    WHERE u.role='student'

    ORDER BY u.full_name ASC

    "

);


?>
<?php

$total_students = mysqli_fetch_assoc(

    mysqli_query(

        $conn,

        "

        SELECT COUNT(*) total

        FROM users

        WHERE role='student'

        "

    )

)['total'];

$total_logs = mysqli_fetch_assoc(

    mysqli_query(

        $conn,

        "

        SELECT COUNT(*) total

        FROM log_entries

        "

    )

)['total'];

$total_evidence = mysqli_fetch_assoc(

    mysqli_query(

        $conn,

        "

        SELECT COUNT(*) total

        FROM weekly_evidence

        "

    )

)['total'];

?>

<div class="progress-cards">

    <div class="progress-card">

        <h3><?php echo $total_students; ?></h3>

        <p>Total Students</p>

    </div>

    <div class="progress-card">

        <h3><?php echo $total_logs; ?></h3>

        <p>Total Logs</p>

    </div>

    <div class="progress-card">

        <h3><?php echo $total_evidence; ?></h3>

        <p>Total Evidence</p>

    </div>

</div>

<div class="progress-container">

    <h2>Student Progress Monitor</h2>

    <table>

        <tr>

            <th>Student</th>

            <th>Matric No</th>

            <th>Department</th>

            <th>Logs</th>

            <th>Evidence</th>

            <th>Progress</th>

        </tr>

        <?php while($row = mysqli_fetch_assoc($query)): ?>

        <?php

        $logs = $row['total_logs'];

        $evidence = $row['total_evidence'];

        /*
        24 weeks SIWES
        */

        $log_percent = min(

            ($logs / 120) * 100,

            100

        );

        $evidence_percent = min(

            ($evidence / 24) * 100,

            100

        );

        $overall = round(

            ($log_percent + $evidence_percent) / 2

        );

        ?>

        <tr>

            <td>
                <?php echo $row['full_name']; ?>
            </td>

            <td>
                <?php echo $row['matric_no']; ?>
            </td>

            <td>
                <?php echo $row['department']; ?>
            </td>

            <td>
                <?php echo $logs; ?>/120
            </td>

            <td>
                <?php echo $evidence; ?>/24
            </td>

            <td>

                <div class="progress-bar">

                    <div
                    class="progress-fill"
                    style="width:<?php echo $overall; ?>%;">

                        <?php echo $overall; ?>%

                    </div>

                </div>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

<?php require_once 'footer.php'; ?>