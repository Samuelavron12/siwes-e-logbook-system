<?php
require_once 'header.php';
require_once '../config/db.php';

/* STUDENTS */

$students = $conn->query("
    SELECT * FROM users
    WHERE role = 'student'
");

/* SUPERVISORS */

$supervisors = $conn->query("
    SELECT * FROM users
    WHERE role = 'supervisor'
");
?>

<div class="table-container">

    <h2>Assign Supervisor</h2>

    <br>

    <form action="save-assignment.php"
          method="POST">

        <!-- STUDENT -->

        <label>Select Student</label>

        <select name="student_id" required>

            <option value="">
                Choose Student
            </option>

            <?php while($student = $students->fetch_assoc()): ?>

                <option value="<?php echo $student['user_id']; ?>">

                    <?php echo $student['full_name']; ?>

                </option>

            <?php endwhile; ?>

        </select>

        <br><br>

        <!-- SUPERVISOR -->

        <label>Select Supervisor</label>

        <select name="supervisor_id" required>

            <option value="">
                Choose Supervisor
            </option>

            <?php while($supervisor = $supervisors->fetch_assoc()): ?>

                <option value="<?php echo $supervisor['user_id']; ?>">

                    <?php echo $supervisor['full_name']; ?>

                </option>

            <?php endwhile; ?>

        </select>

        <br><br>

        <button type="submit"
                name="assign_supervisor">

            Assign Supervisor

        </button>

    </form>

</div>

<?php
require_once 'footer.php';
?>