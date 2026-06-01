<?php

require_once 'header.php';
require_once '../config/db.php';

$supervisor_id = $_SESSION['user_id'];

$query = mysqli_query(

    $conn,

    "

    SELECT

        u.user_id,
        u.full_name,
        p.passport,
        p.matric_no,
        p.department,
        p.company_name

    FROM student_supervisors ss

    JOIN users u
    ON ss.student_id = u.user_id

    LEFT JOIN student_profiles p
    ON ss.student_id = p.student_id

    WHERE ss.supervisor_id = '$supervisor_id'

    ORDER BY u.full_name ASC

    "

);

?>

<div class="students-container">

    <h2>Assigned Students</h2>

    <div class="students-grid">

        <?php while($row = mysqli_fetch_assoc($query)): ?>

        <div class="student-card">

            <img
            src="../uploads/<?php echo $row['passport']; ?>"
            alt="Student">

            <h3>
                <?php echo $row['full_name']; ?>
            </h3>

            <p>
                <?php echo $row['matric_no']; ?>
            </p>

            <p>
                <?php echo $row['department']; ?>
            </p>

            <p>
                <?php echo $row['company_name']; ?>
            </p>

            <a
            href="student-profile.php?id=<?php echo $row['user_id']; ?>"
            class="view-btn">

            View Profile

            </a>

        </div>

        <?php endwhile; ?>

    </div>

</div>

<?php require_once 'footer.php'; ?>
