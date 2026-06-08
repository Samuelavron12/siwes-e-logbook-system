<?php

require_once 'header.php';
require_once '../config/db.php';

$query = mysqli_query(

    $conn,

    "

    SELECT

        we.*,
        u.full_name

    FROM weekly_evidence we

    INNER JOIN users u

    ON we.student_id = u.user_id

    ORDER BY we.uploaded_at DESC

    "

);

?>

<div class="log-container">

    <h2>All Weekly Evidence</h2>

    <table>

        <tr>

            <th>Student</th>

            <th>Week</th>

            <th>Title</th>

            <th>Evidence</th>

            <th>Date</th>

            <th>Action</th>

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

                <?php

                $ext = strtolower(

                    pathinfo(

                        $row['evidence_file'],

                        PATHINFO_EXTENSION

                    )

                );

                ?>

                <?php if(

                    $ext == 'jpg' ||

                    $ext == 'jpeg' ||

                    $ext == 'png'

                ): ?>

                    <img

                    src="../uploads/evidence/<?php echo $row['evidence_file']; ?>"

                    width="100"

                    height="70"

                    style="object-fit:cover;border-radius:8px;">

                <?php else: ?>

                    PDF File

                <?php endif; ?>

            </td>

            <td>

                <?php echo $row['uploaded_at']; ?>

            </td>

            <td>

                <a

                class="edit-btn"

                href="../uploads/evidence/<?php echo $row['evidence_file']; ?>"

                target="_blank">

                    View

                </a>

                <a

                class="delete-btn"

                href="delete-evidence.php?id=<?php echo $row['id']; ?>"

                onclick="return confirm('Delete Evidence?')">

                    Delete

                </a>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

<?php require_once 'footer.php'; ?>