<?php

require_once 'header.php';
require_once '../config/db.php';

$query = mysqli_query(

    $conn,

    "

    SELECT

        sp.*,
        u.full_name,
        u.email

    FROM student_profiles sp

    INNER JOIN users u

    ON sp.student_id = u.user_id

    ORDER BY sp.profile_id DESC

    "

);

?>

<div class="profiles-page">

    <h2>Student Profiles</h2>

    <div class="profiles-grid">

        <?php while($row = mysqli_fetch_assoc($query)): ?>

        <div class="profile-card-small">

            <div class="profile-header-small">

                <img
                src="../uploads/<?php echo $row['passport']; ?>"
                alt="passport">

                <div class="profile-name">

                    <h3>
                        <?php echo $row['full_name']; ?>
                    </h3>

                    <p>
                        <?php echo $row['matric_no']; ?>
                    </p>

                </div>

            </div>

            <div class="profile-body-small">

                <p>
                    <strong>Department:</strong>
                    <?php echo $row['department']; ?>
                </p>

                <p>
                    <strong>Company:</strong>
                    <?php echo $row['company_name']; ?>
                </p>

                <p>
                    <strong>Supervisor:</strong>
                    <?php echo $row['industry_supervisor']; ?>
                </p>

            </div>

            <a
            href="student-profile.php?id=<?php echo $row['student_id']; ?>"
            class="view-btn">

                View Profile

            </a>

        </div>

        <?php endwhile; ?>

    </div>

</div>

<?php require_once 'footer.php'; ?>