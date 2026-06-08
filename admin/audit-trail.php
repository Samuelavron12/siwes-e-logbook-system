<?php

require_once 'header.php';
require_once '../config/db.php';

$query = mysqli_query(

    $conn,

    "

    SELECT

        a.*,
        u.full_name,
        u.role

    FROM audit_logs a

    LEFT JOIN users u

    ON a.user_id = u.user_id

    ORDER BY a.log_id DESC

    "

);

?>

<div class="audit-page">

    <h2>System Activity Log</h2>

    <div class="table-responsive">

        <table>

            <tr>

                <th>User</th>

                <th>Role</th>

                <th>Activity</th>

                <th>Date</th>

            </tr>

            <?php while($row = mysqli_fetch_assoc($query)): ?>

            <tr>

                <td>
                    <?php echo $row['full_name']; ?>
                </td>

                <td>
                    <?php echo ucfirst($row['role']); ?>
                </td>

                <td>
                    <?php echo $row['activity']; ?>
                </td>

                <td>
                    <?php echo $row['created_at']; ?>
                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

<?php require_once 'footer.php'; ?>