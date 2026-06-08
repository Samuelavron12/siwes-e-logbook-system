<?php

require_once 'header.php';
require_once '../config/db.php';

$query = mysqli_query(

    $conn,

    "

    SELECT

        le.*,

        u.full_name,

        sp.matric_no

    FROM log_entries le

    INNER JOIN users u

    ON le.student_id = u.user_id

    LEFT JOIN student_profiles sp

    ON le.student_id = sp.student_id

    ORDER BY le.log_date DESC

    "

);

?>

<div class="logs-page">

    <h2>All Student Logs</h2>

    <div class="table-responsive">

        <table>

            <tr>

                <th>Student</th>
                <th>Matric No</th>
                <th>Date</th>
                <th>Day</th>
                <th>Title</th>
                <th>Status</th>
                <th>Action</th>

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
                    <?php echo $row['log_date']; ?>
                </td>

                <td>
                    <?php echo date('l',strtotime($row['log_date'])); ?>
                </td>

                <td>
                    <?php echo $row['title']; ?>
                </td>

                <td>

                    <span class="status-badge <?php echo $row['status']; ?>">

                        <?php echo ucfirst($row['status']); ?>

                    </span>

                </td>

                <td>

                    <a

                    href="view-log.php?id=<?php echo $row['id']; ?>"

                    class="view-btn">

                        View

                    </a>

                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

<?php require_once 'footer.php'; ?>