<?php
require_once 'header.php';
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];

$result = mysqli_query(

    $conn,

    "

    SELECT *

    FROM weekly_evidence

    WHERE student_id = '$student_id'

    ORDER BY id DESC

    "
);
?>

<div class="evidence-list">

    <h2>My Weekly Evidence</h2>

    <table>

        <tr>

            <th>Week</th>

            <th>Title</th>

            <th>File</th>

            <th>Preview</th>

            <th>Date</th>

            <th>Actions</th>

        </tr>

        <?php while($row = mysqli_fetch_assoc($result)): ?>

        <tr>

            <td>

                Week <?php echo $row['week_no']; ?>

            </td>

            <td>

                <?php echo $row['title']; ?>

            </td>

            <!-- FILE LINK -->

            <td>

                <a
                target="_blank"
                href="../uploads/evidence/<?php echo $row['evidence_file']; ?>">

                    View File

                </a>

            </td>

            <!-- IMAGE PREVIEW -->

            <td>

                <?php

                $extension = strtolower(

                    pathinfo(

                        $row['evidence_file'],

                        PATHINFO_EXTENSION

                    )

                );

                if($extension != "pdf"){

                ?>

                    <img

                    src="../uploads/evidence/<?php echo $row['evidence_file']; ?>"

                    width="100"

                    height="70"

                    style="object-fit:cover;border-radius:8px;">

                <?php } else { ?>

                    <span>PDF File</span>

                <?php } ?>

            </td>

            <!-- DATE -->

            <td>

                <?php echo $row['uploaded_at']; ?>

            </td>

            <!-- ACTIONS -->

            <td>

                <div class="actions">

                    <a

                    class="edit-btn"

                    href="edit-evidence.php?id=<?php echo $row['id']; ?>">

                        Edit

                    </a>

                    <a

                    class="delete-btn"

                    href="delete-evidence.php?id=<?php echo $row['id']; ?>"

                    onclick="return confirm('Delete this evidence?')">

                        Delete

                    </a>

                </div>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

<?php
require_once 'footer.php';
?>