<?php

require_once 'header.php';
require_once '../config/db.php';

$id = $_GET['id'];

$query = mysqli_query(

    $conn,

    "

    SELECT

        sp.*,
        u.full_name,
        u.email,
        u.phone_number

    FROM student_profiles sp

    INNER JOIN users u

    ON sp.student_id = u.user_id

    WHERE sp.student_id='$id'

    "

);

$student = mysqli_fetch_assoc($query);

?>

<div class="profile-display">

        <div class="profile-top">

        <img
        src="../uploads/<?php echo $student['passport']; ?>"
        alt="passport">

        <div class="profile-info">

            <h2>
                <?php echo $student['full_name']; ?>
            </h2>

            <p>
                <strong>Matric No:</strong>
                <?php echo $student['matric_no']; ?>
            </p>

            <p>
                <strong>Email:</strong>
                <?php echo $student['email']; ?>
            </p>

            <p>
                <strong>Phone:</strong>
                <?php echo $student['phone_number']; ?>
            </p>

        </div>

    </div>

    <div class="profile-grid">

        <div class="profile-card">

            <h3>Academic Information</h3>

            <div class="detail-row">
                <span>School</span>
                <strong><?php echo $student['school']; ?></strong>
            </div>

            <div class="detail-row">
                <span>Faculty</span>
                <strong><?php echo $student['faculty']; ?></strong>
            </div>

            <div class="detail-row">
                <span>Department</span>
                <strong><?php echo $student['department']; ?></strong>
            </div>

            <div class="detail-row">
                <span>Level</span>
                <strong><?php echo $student['level']; ?></strong>
            </div>

        </div>

        <div class="profile-card">

        <h3>Organization Information</h3>

        <div class="detail-row">
            <span>Company</span>
            <strong><?php echo $student['company_name']; ?></strong>
        </div>

        <div class="detail-row">
            <span>Supervisor</span>
            <strong><?php echo $student['industry_supervisor']; ?></strong>
        </div>

        <div class="detail-row">
            <span>Phone</span>
            <strong><?php echo $student['supervisor_phone']; ?></strong>
        </div>

        <div class="detail-row">
            <span>Start Date</span>
            <strong><?php echo $student['start_date']; ?></strong>
        </div>

        <div class="detail-row">
            <span>End Date</span>
            <strong><?php echo $student['end_date']; ?></strong>
        </div>

    </div>


</div>

<?php require_once 'footer.php'; ?>