<?php

require_once 'header.php';
require_once '../config/db.php';

$supervisor_id = $_SESSION['user_id'];

$students = mysqli_query(

    $conn,

    "

    SELECT

        u.user_id,
        u.full_name,

        sp.matric_no,
        sp.department,

        (
            SELECT COUNT(*)

            FROM log_entries l

            WHERE l.student_id = u.user_id

        ) AS total_logs

    FROM student_supervisors ss

    INNER JOIN users u

    ON ss.student_id = u.user_id

    LEFT JOIN student_profiles sp

    ON u.user_id = sp.student_id

    WHERE ss.supervisor_id='$supervisor_id'

    ORDER BY u.full_name ASC

    "

);

?>

<div class="attendance-page">

    <h2>Attendance Summary</h2>

    <div class="attendance-table">

        <table>

            <thead>

                <tr>

                    <th>Student</th>

                    <th>Matric No</th>

                    <th>Department</th>

                    <th>Logs Submitted</th>

                    <th>Completion</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                <?php while($student = mysqli_fetch_assoc($students)): ?>

                <?php

                $required_logs = 120;

                $percentage = 0;

                if($required_logs > 0){

                    $percentage = round(

                        ($student['total_logs'] / $required_logs) * 100

                    );

                }

                ?>

                <tr>

                    <td>

                        <?php echo $student['full_name']; ?>

                    </td>

                    <td>

                        <?php echo $student['matric_no']; ?>

                    </td>

                    <td>

                        <?php echo $student['department']; ?>

                    </td>

                    <td>

                        <?php echo $student['total_logs']; ?>

                    </td>

                    <td>

                        <div class="progress-bar">

                            <div

                            class="progress-fill"

                            style="width:<?php echo min($percentage,100); ?>%">

                            </div>

                        </div>

                        <small>

                            <?php echo $percentage; ?>%

                        </small>

                    </td>

                    <td>

                        <?php

                        if($percentage >= 80){

                            echo '<span class="good">Excellent</span>';

                        }

                        elseif($percentage >= 50){

                            echo '<span class="warning">Average</span>';

                        }

                        else{

                            echo '<span class="danger">Poor</span>';

                        }

                        ?>

                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

<?php require_once 'footer.php'; ?>