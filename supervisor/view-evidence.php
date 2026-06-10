<?php
require_once 'header.php';
require_once '../config/db.php';

$query = mysqli_query(

    $conn,

    "

    SELECT
        weekly_evidence.*,
        users.full_name

    FROM weekly_evidence

    INNER JOIN users

    ON weekly_evidence.student_id = users.user_id

    ORDER BY weekly_evidence.id DESC

    "
);
?>

<div class="log-container">

    <h2>Student Weekly Evidence</h2>
    <div class="table-scroll">

    <table>

        <tr>

            <th>Student</th>

            <th>Week</th>

            <th>Title</th>

            <th>Evidence</th>

            <th>Date</th>

        </tr>

        <?php while($row = mysqli_fetch_assoc($query)): ?>

        <tr>

            <td>
                <?php echo $row['full_name']; ?>
            </td>

            <td>
                Week <?php echo $row['week_no']; ?>
            </td>

            <td>
                <?php echo $row['title']; ?>
            </td>

            <td>

                <a target="_blank"
                   href="../uploads/evidence/<?php echo $row['evidence_file']; ?>">

                    View Evidence

                </a>

            </td>

            <td>
                <?php echo $row['uploaded_at']; ?>
            </td>

        </tr>

        <?php endwhile; ?>

    </table>
    </div>


</div>

<?php
require_once 'footer.php';
?>