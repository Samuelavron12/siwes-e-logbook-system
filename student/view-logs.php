<?php
require_once 'header.php';
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];

$result = $conn->query("
    SELECT * FROM log_entries
    WHERE student_id = '$student_id'
    ORDER BY log_date DESC
");
?>

<div class="log-container">

    <h2>My Log Entries</h2>

    <?php if(isset($_GET['success'])): ?>
        <p class="success">Log saved successfully</p>
    <?php endif; ?>

    <table>

        <tr>
            <th>Date</th>
            <th>Title</th>
            <th>Activity</th>
            <th>Status</th>
            <th>Attachment</th>
            <th>Supervisor Comment</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['log_date']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['activity']; ?></td>
            <td><?php echo $row['status']; ?></td>

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
            <td>
                <?php
                echo $row['supervisor_comment']
                ? $row['supervisor_comment']
                : 'No Comment Yet';
                ?>
            </td>
            <td class="actions">    
                <!-- EDIT -->
                <a class="edit-btn"href="edit-log.php?id=<?php echo $row['id']; ?>"> Edit </a>
                <!-- DELETE -->
                <a class="delete-btn" href="delete-log.php?id=<?php echo $row['id']; ?>"  onclick="return confirm('Delete this log entry?')">  Delete </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php
require_once 'footer.php';
?>