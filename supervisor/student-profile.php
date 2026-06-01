<?php

require_once 'header.php';
require_once '../config/db.php';

$student_id = $_GET['id'];

$query = mysqli_query(

    $conn,

    "

    SELECT

        u.full_name,
        u.email,
        u.phone_number,
        p.*

    FROM users u

    JOIN student_profiles p

    ON u.user_id = p.student_id

    WHERE u.user_id='$student_id'

    "

);

$student = mysqli_fetch_assoc($query);

?>

<div class="profile-display">

    <div class="profile-top">

        <img
        src="../uploads/<?php echo $student['passport']; ?>" class="profile-passport">

        <div class="name-profile">

            <h2>
                <?php echo $student['full_name']; ?>
            </h2>

            <p>
                <?php echo $student['matric_no']; ?>
            </p>

        </div>

    </div>

    <div class="profile-grid">

        <div class="profile-box">

            <h3>Academic Information</h3>

            <p>School:
            <?php echo $student['school']; ?></p>

            <p>Faculty:
            <?php echo $student['faculty']; ?></p>

            <p>Department:
            <?php echo $student['department']; ?></p>

            <p>Level:
            <?php echo $student['level']; ?></p>

        </div>

        <div class="profile-box">

            <h3>Organization Information</h3>

            <p>Company:
            <?php echo $student['company_name']; ?></p>

            <p>Supervisor:
            <?php echo $student['industry_supervisor']; ?></p>

            <p>Phone:
            <?php echo $student['supervisor_phone']; ?></p>

            <p>Start:
            <?php echo $student['start_date']; ?></p>

            <p>End:
            <?php echo $student['end_date']; ?></p>

        </div>

    </div>

</div>
<a href="student.php"  class="back"> go back</a>

<?php require_once 'footer.php'; ?>