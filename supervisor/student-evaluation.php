<?php

require_once 'header.php';
require_once '../config/db.php';

$supervisor_id = $_SESSION['user_id'];

if(isset($_POST['save_evaluation']))
{

    $student_id = $_POST['student_id'];

    $attendance = $_POST['attendance'];

    $punctuality = $_POST['punctuality'];

    $technical_skills = $_POST['technical_skills'];

    $communication = $_POST['communication'];

    $professionalism = $_POST['professionalism'];

    $remarks = mysqli_real_escape_string(
        $conn,
        $_POST['remarks']
    );

    $total_score =

    $attendance +
    $punctuality +
    $technical_skills +
    $communication +
    $professionalism;

    $check = mysqli_query(

        $conn,

        "

        SELECT *

        FROM student_evaluations

        WHERE student_id='$student_id'

        AND supervisor_id='$supervisor_id'

        "

    );

    if(mysqli_num_rows($check) > 0)
    {

        mysqli_query(

            $conn,

            "

            UPDATE student_evaluations

            SET

            attendance='$attendance',
            punctuality='$punctuality',
            technical_skills='$technical_skills',
            communication='$communication',
            professionalism='$professionalism',
            total_score='$total_score',
            remarks='$remarks'

            WHERE student_id='$student_id'

            AND supervisor_id='$supervisor_id'

            "

        );

    }
    else
    {

        mysqli_query(

            $conn,

            "

            INSERT INTO student_evaluations(

            student_id,
            supervisor_id,
            attendance,
            punctuality,
            technical_skills,
            communication,
            professionalism,
            total_score,
            remarks

            )

            VALUES(

            '$student_id',
            '$supervisor_id',
            '$attendance',
            '$punctuality',
            '$technical_skills',
            '$communication',
            '$professionalism',
            '$total_score',
            '$remarks'

            )

            "

        );

    }

    echo "<script>alert('Evaluation Saved');</script>";

}

$students = mysqli_query(

    $conn,

    "

    SELECT

        u.user_id,
        u.full_name,
        sp.matric_no

    FROM student_supervisors ss

    INNER JOIN users u
    ON ss.student_id = u.user_id

    LEFT JOIN student_profiles sp
    ON sp.student_id = u.user_id

    WHERE ss.supervisor_id='$supervisor_id'

    "

);

?>

<div class="evaluation-page">

    <h2>Student Evaluation</h2>

    <?php while($student = mysqli_fetch_assoc($students)): ?>

    <form method="POST" class="evaluation-card">

        <input
        type="hidden"
        name="student_id"
        value="<?php echo $student['user_id']; ?>">

        <h3>

            <?php echo $student['full_name']; ?>

        </h3>

        <p>

            <?php echo $student['matric_no']; ?>

        </p>

        <label>Attendance (20)</label>
        <input type="number" name="attendance" min="0" max="20" required>

        <label>Punctuality (20)</label>
        <input type="number" name="punctuality" min="0" max="20" required>

        <label>Technical Skills (20)</label>
        <input type="number" name="technical_skills" min="0" max="20" required>

        <label>Communication (20)</label>
        <input type="number" name="communication" min="0" max="20" required>

        <label>Professionalism (20)</label>
        <input type="number" name="professionalism" min="0" max="20" required>

        <label>Remarks</label>

        <textarea
        name="remarks"></textarea>

        <button
        type="submit"
        name="save_evaluation">

            Save Evaluation

        </button>

    </form>

    <?php endwhile; ?>

</div>

<?php require_once 'footer.php'; ?>