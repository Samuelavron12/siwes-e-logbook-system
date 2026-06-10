<?php

require_once 'header.php';
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];

$query = mysqli_query(

    $conn,

    "

    SELECT

    u.*,

    sp.passport,
    sp.organization,
    sp.position,
    sp.address,
    sp.bio

    FROM student_supervisors ss

    INNER JOIN users u

    ON ss.supervisor_id = u.user_id

    LEFT JOIN supervisor_profiles sp

    ON sp.supervisor_id = u.user_id

    WHERE ss.student_id='$student_id'

    LIMIT 1

    "

);

$supervisor = mysqli_fetch_assoc($query);

?>

<div class="supervisor-page">

    <h2>My Supervisor</h2>

    <?php if($supervisor): ?>

        <div class="supervisor-card">

            <img

            src="../uploads/<?php echo $supervisor['passport']; ?>"

            alt="passport">

            <div class="supervisor-info">

                <h3>

                    <?php echo $supervisor['full_name']; ?>

                </h3>

                <p>

                    <?php echo $supervisor['email']; ?>

                </p>

                <p>

                    <?php echo $supervisor['phone_number']; ?>

                </p>

                <p>

                    <?php echo $supervisor['organization']; ?>

                </p>

                <p>

                    <?php echo $supervisor['position']; ?>

                </p>

            </div>

        </div>

        <div class="bio-card">

            <h3>Biography</h3>

            <p>

                <?php echo $supervisor['bio']; ?>

            </p>

        </div>

    <?php endif; ?>

</div>

<?php require_once 'footer.php'; ?>