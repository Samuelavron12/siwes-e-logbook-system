<?php
require_once 'header.php';
require_once '../config/db.php';

$supervisor_id = $_SESSION['user_id'];

$query = $conn->query("

    SELECT
    log_entries.*,
    users.full_name

    FROM log_entries

    INNER JOIN users
    ON log_entries.student_id = users.user_id

    INNER JOIN student_supervisors
    ON users.user_id = student_supervisors.student_id

    WHERE student_supervisors.supervisor_id = '$supervisor_id'

    ORDER BY log_entries.created_at DESC
");
if(!$query){
    die($conn->error);
}
?>

<div class="table-container">

    <h2>Student Log Entries</h2>

    <br>

    <table>

        <tr>

            <th>Student</th>

            <th>Date</th>

            <th>Title</th>

            <th>Activity</th>

            <th>Status</th>

            <th>Attachment</th>

            <th>Action</th>

        </tr>

        <?php while($row = $query->fetch_assoc()): ?>

        <tr>

            <td>
                <?php echo $row['full_name']; ?>
            </td>

            <td>
                <?php echo $row['log_date']; ?>
            </td>

            <td>
                <?php echo $row['title']; ?>
            </td>

            <td>
                <?php echo $row['activity']; ?>
            </td>

            <td>
                <?php echo $row['status']; ?>
            </td>

            <td>

                <?php if($row['attachment']): ?>

                    <a href="../uploads/<?php echo $row['attachment']; ?>"
                       target="_blank">

                       View File

                    </a>

                <?php else: ?>

                    No File

                <?php endif; ?>

            </td>
            <td class="action-buttons">
                <!-- APPROVE -->
                <a class="approve-btn"
                href="approve-log.php?id=<?php echo $row['id']; ?>">
                    Approve
                </a>
                <!-- REJECT -->
                <a class="reject-btn"
                href="reject-log.php?id=<?php echo $row['id']; ?>">
                    Reject
                </a>
                <!-- COMMENT -->
                <a class="comment-btn"
                href="comment-log.php?id=<?php echo $row['id']; ?>">
                    Comment
                </a> 
            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

<?php
require_once 'footer.php';
?>