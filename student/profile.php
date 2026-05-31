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

<?php if(!$profile): ?>

<!-- STEP 1 -->

<div class="profile-form-container">

    <h2>Student Profile Setup</h2>

    <form action="save-profile.php" method="POST" enctype="multipart/form-data">
            <!------ STEP 1 personal information and school details ---------->
        <div class="step-form active-step">
            <h3>Personal Information</h3>
            <div class="profile-form-grid">
                <input type="text" name="matric_no" placeholder="Matric Number" required>
                <input type="text"name="school" placeholder="School" required>
                <input type="text" name="faculty" placeholder="Faculty" required>
                <input type="text" name="department" placeholder="Department" required>
                <input type="text" name="level" placeholder="Level" required>
            <!----------- gender zone--------------------->
                <select name="gender" required>
                    <option value=""> Select Gender </option>
                    <option value="Male"> Male </option>
                    <option value="Female"> Female </option>
                </select>

            </div>

            <textarea name="address"class="full-width-textarea" placeholder="Address" required></textarea>
                <!------ passport upload------------>
            <div class="passport-upload">
                <label>Passport Photo</label>
                <input type="file" name="passport" required>
            </div> 
            <button type="button" id="nextBtn" class="profile-next-btn">
                Next
            </button>

        </div>

        <!--------- STEP 2 organization details  --------------->

        <div class="step-form">
            <h3>Organization Details</h3>
            <div class="profile-form-grid">
                <input type="text" name="company_name" placeholder="Company Name" required>
                <input type="text" name="industry_supervisor" placeholder="Industry Supervisor Name" required>
                <input type="text" name="supervisor_phone" placeholder="Supervisor Phone" required>
                <input type="date" name="start_date" placeholder="start date" required>
                <input type="date" name="end_date" placeholder="end date" required>
            </div>
            <textarea name="company_address" class="full-width-textarea" placeholder="Company Address" required></textarea>
            <button type="submit" name="save_profile" class="profile-next-btn">
                Finish
            </button>
        </div>
    </form>

</div>
<!------------ visibility zone----------------->
<?php else: ?>

<!-- visible profile display for the user -->

<div class="profile-display">
    <div class="profile-top">

    <img src="../uploads/<?php echo trim($profile['passport']); ?>"
     alt="Profile Image">
        <div class="profile-info">
            <h2> <?php echo $_SESSION['full_name']; ?> </h2>
            <p>  <?php echo $profile['matric_no']; ?> </p>
        </div>
    </div>
    <div class="profile-grid">
        <div class="profile-card">
            <h3>Academic Details</h3>
            <p><strong>School:</strong> <?php echo $profile['school']; ?></p>
            <p><strong>Faculty:</strong> <?php echo $profile['faculty']; ?></p>
            <p><strong>Department:</strong> <?php echo $profile['department']; ?></p>
            <p><strong>Level:</strong> <?php echo $profile['level']; ?></p>
        </div>

        <div class="profile-card">
            <h3>Organization Details</h3>
            <p><strong>Company:</strong><?php echo $profile['company_name']; ?></p>
            <p><strong>Supervisor:</strong> <?php echo $profile['industry_supervisor']; ?></p>
            <p><strong>Phone:</strong> <?php echo $profile['supervisor_phone']; ?></p>
            <p><strong>Address:</strong> <?php echo $profile['address']; ?></p>
            <p><strong>Starts:</strong> <?php echo $profile['start_date']; ?></p>
            <p><strong>End:</strong>  <?php echo $profile['end_date']; ?></p>
        </div>
    </div>
    <a class="edit-profile-btn" href="edit-profile.php"> Edit Profile </a>
</div>
<?php endif; ?>
<!-------scripting layer to give the system it functionality---------->
<script>

const nextBtn =
document.getElementById("nextBtn");

if(nextBtn){
 
    nextBtn.addEventListener("click", () => {

        document
        .querySelectorAll(".step-form")[0]
        .classList.remove("active-step");

        document
        .querySelectorAll(".step-form")[1]
        .classList.add("active-step");
    });
}

</script>
<!------------ footer---------->
<?php
require_once 'footer.php';
?>,n