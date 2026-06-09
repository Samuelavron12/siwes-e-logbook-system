
<?php

require_once 'header.php';
require_once '../config/db.php';

$supervisor_id = $_SESSION['user_id'];

$query = mysqli_query(

    $conn,

    "

    SELECT

        u.*,
        sp.*

    FROM users u

    LEFT JOIN supervisor_profiles sp

    ON u.user_id = sp.supervisor_id

    WHERE u.user_id='$supervisor_id'

    "

);

$profile = mysqli_fetch_assoc($query);

?>

<div class="supervisor-profile-page">

    <div class="profile-header">

        <div class="passport-box">

            <img
            src="../uploads/<?php echo !empty($profile['passport']) ? $profile['passport'] : 'default.png'; ?>"
            alt="passport">

        </div>

        <div class="profile-info">

            <h2>

                <?php echo $profile['full_name']; ?>

            </h2>

            <p>

                <strong>Email:</strong>

                <?php echo $profile['email']; ?>

            </p>

            <p>

                <strong>Phone:</strong>

                <?php echo $profile['phone_number']; ?>

            </p>

            <p>

                <strong>Role:</strong>

                Supervisor

            </p>

        </div>

    </div>

    <div class="profile-grid">

        <div class="profile-card">

            <h3>Organization Details</h3>

            <div class="detail-row">

                <span>Organization</span>

                <strong>

                    <?php echo $profile['organization']; ?>

                </strong>

            </div>

            <div class="detail-row">

                <span>Position</span>

                <strong>

                    <?php echo $profile['position']; ?>

                </strong>

            </div>

        </div>

        <div class="profile-card">

            <h3>Contact Information</h3>

            <div class="detail-row">

                <span>Address</span>

                <strong>

                    <?php echo $profile['address']; ?>

                </strong>

            </div>

        </div>

        <div class="profile-card full-width">

            <h3>Biography</h3>

            <p>

                <?php echo $profile['bio']; ?>

            </p>

        </div>

    </div>

</div

<?php require_once 'footer.php'; ?>