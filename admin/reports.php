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
        sp.company_name

    FROM users u

    LEFT JOIN student_profiles sp

    ON u.user_id = sp.student_id

    WHERE u.role='student'

    ORDER BY u.full_name ASC

    "

);

?>

<div class="reports-page">

    <h2>Student Reports</h2>

    <table>

        <tr>

            <th>Student</th>
            <th>Matric No</th>
            <th>Department</th>
            <th>Company</th>
            <th>Report</th>

        </tr>

        <?php while($row = mysqli_fetch_assoc($query)): ?>

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
                <?php echo $row['company_name']; ?>
            </td>

            <td>

            <a href="generate-student-report.php?student_id=<?php echo $row['user_id']; ?>" class="view-btn">Download PDF</a>
            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

<?php require_once 'footer.php'; ?>