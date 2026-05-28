<?php
require_once 'header.php';
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];

$query = $conn->query("
    SELECT * FROM student_profiles
    WHERE student_id = '$student_id'
");

$profile = $query->fetch_assoc();
?>

<div class="profile-form-container">

    <h2>Edit Profile</h2>

    <form action="update-profile.php"
          method="POST">

        <input type="hidden"
               name="profile_id"
               value="<?php echo $profile['profile_id']; ?>">

        <!-- GRID -->

        <div class="profile-edit-grid">

            <!-- LEFT -->

            <div class="edit-card">

                <h3>Academic Details</h3>

                <input type="text"
                       name="matric_no"
                       value="<?php echo $profile['matric_no']; ?>"
                       placeholder="Matric Number">

                <input type="text"
                       name="school"
                       value="<?php echo $profile['school']; ?>"
                       placeholder="School">

                <input type="text"
                       name="faculty"
                       value="<?php echo $profile['faculty']; ?>"
                       placeholder="Faculty">

                <input type="text"
                       name="department"
                       value="<?php echo $profile['department']; ?>"
                       placeholder="Department">

                <input type="text"
                       name="level"
                       value="<?php echo $profile['level']; ?>"
                       placeholder="Level">

            </div>

            <!-- RIGHT -->

            <div class="edit-card">

                <h3>Organization Details</h3>

                <input type="text"
                       name="company_name"
                       value="<?php echo $profile['company_name']; ?>"
                       placeholder="Company Name">

                <textarea name="company_address"
                          placeholder="Company Address"><?php echo $profile['company_address']; ?></textarea>

                <input type="text"
                       name="industry_supervisor"
                       value="<?php echo $profile['industry_supervisor']; ?>"
                       placeholder="Supervisor Name">

                <input type="text"
                       name="supervisor_phone"
                       value="<?php echo $profile['supervisor_phone']; ?>"
                       placeholder="Supervisor Phone">

            </div>

        </div>

        <!-- BUTTON -->

        <button type="submit"
                name="update_profile"
                class="update-profile-btn">

            Update Profile

        </button>

    </form>

</div>

<?php
require_once 'footer.php';
?>