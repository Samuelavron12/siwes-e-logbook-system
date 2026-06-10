<?php

require_once 'header.php';
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];

$query = mysqli_query(

    $conn,

    "

    SELECT *

    FROM evaluations

    WHERE student_id='$student_id'

    LIMIT 1

    "

);

$evaluation = mysqli_fetch_assoc($query);

?>

<div class="evaluation-result-page">

    <h2>Supervisor Evaluation</h2>

    <?php if($evaluation): ?>

        <div class="evaluation-card">

            <div class="score-box">

                <h1>
                    <?php echo $evaluation['total_score']; ?>/100
                </h1>

                <p>Total Score</p>

            </div>

            <div class="evaluation-grid">

                <div class="score-item">
                    Attendance:
                    <strong>
                        <?php echo $evaluation['attendance']; ?>
                    </strong>
                </div>

                <div class="score-item">
                    Punctuality:
                    <strong>
                        <?php echo $evaluation['punctuality']; ?>
                    </strong>
                </div>

                <div class="score-item">
                    Technical Skills:
                    <strong>
                        <?php echo $evaluation['technical_skills']; ?>
                    </strong>
                </div>

                <div class="score-item">
                    Communication:
                    <strong>
                        <?php echo $evaluation['communication']; ?>
                    </strong>
                </div>

                <div class="score-item">
                    Professionalism:
                    <strong>
                        <?php echo $evaluation['professionalism']; ?>
                    </strong>
                </div>

            </div>

            <div class="remarks-box">

                <h3>Supervisor Remarks</h3>

                <p>
                    <?php echo $evaluation['remarks']; ?>
                </p>

            </div>

        </div>

    <?php else: ?>

        <div class="empty-box">

            No evaluation submitted yet.

        </div>

    <?php endif; ?>

</div>

<?php require_once 'footer.php'; ?>