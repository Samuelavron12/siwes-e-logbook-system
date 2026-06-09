
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
<?php

require_once 'header.php';
require_once '../config/db.php';

$supervisor_id = $_SESSION['user_id'];

if(isset($_POST['save_profile']))
{

    $organization = mysqli_real_escape_string(
        $conn,
        $_POST['organization']
    );

    $position = mysqli_real_escape_string(
        $conn,
        $_POST['position']
    );

    $address = mysqli_real_escape_string(
        $conn,
        $_POST['address']
    );

    $bio = mysqli_real_escape_string(
        $conn,
        $_POST['bio']
    );

    $passport = '';

    if(!empty($_FILES['passport']['name']))
    {

        $passport = time().'_'.
        $_FILES['passport']['name'];

        move_uploaded_file(

            $_FILES['passport']['tmp_name'],

            '../uploads/'.$passport

        );
    }

    mysqli_query(

        $conn,

        "

        INSERT INTO supervisor_profiles(

        supervisor_id,
        passport,
        organization,
        position,
        address,
        bio

        )

        VALUES(

        '$supervisor_id',
        '$passport',
        '$organization',
        '$position',
        '$address',
        '$bio'

        )

        "

    );

    header("Location: profile.php");
    exit();
}

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

<?php if(empty($profile['profile_id'])): ?>

<div class="profile-form-card">


<h2>Complete Profile</h2>

<form
method="POST"
enctype="multipart/form-data">

    <label>Passport</label>

    <input
    type="file"
    name="passport"
    required>

    <label>Organization</label>

    <input
    type="text"
    name="organization"
    required>

    <label>Position</label>

    <input
    type="text"
    name="position"
    required>

    <label>Address</label>

    <textarea
    name="address"
    required></textarea>

    <label>Bio</label>

    <textarea
    name="bio"></textarea>

    <button
    type="submit"
    name="save_profile">

        Finish Profile

    </button>

</form>

</div>

<?php else: ?>

<div class="supervisor-profile">


<div class="profile-top">

    <img
    src="../uploads/<?php echo $profile['passport']; ?>"
    alt="passport">

    <div class="profile-basic">

        <h2>

            <?php echo $profile['full_name']; ?>

        </h2>

        <p>

            <?php echo $profile['email']; ?>

        </p>

        <p>

            <?php echo $profile['phone_number']; ?>

        </p>

    </div>

</div>

<div class="profile-details">

    <div class="detail-box">

        <span>Organization</span>

        <strong>

            <?php echo $profile['organization']; ?>

        </strong>

    </div>

    <div class="detail-box">

        <span>Position</span>

        <strong>

            <?php echo $profile['position']; ?>

        </strong>

    </div>

    <div class="detail-box">

        <span>Address</span>

        <strong>

            <?php echo $profile['address']; ?>

        </strong>

    </div>

    <div class="detail-box">

        <span>Bio</span>

        <strong>

            <?php echo $profile['bio']; ?>

        </strong>

    </div>

</div>

<a
href="edit-profile.php"
class="edit-btn">

    Edit Profile

</a>


</div>

<?php endif; ?>

<?php require_once 'footer.php'; ?>


<?php require_once 'footer.php'; ?>