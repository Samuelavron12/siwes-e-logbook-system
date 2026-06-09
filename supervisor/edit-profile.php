<?php

require_once 'header.php';
require_once '../config/db.php';

$supervisor_id = $_SESSION['user_id'];

$query = mysqli_query(

    $conn,

    "

    SELECT *

    FROM supervisor_profiles

    WHERE supervisor_id='$supervisor_id'

    "

);

$profile = mysqli_fetch_assoc($query);

if(isset($_POST['update_profile']))
{

    $organization = $_POST['organization'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $bio = $_POST['bio'];

    $passport = $profile['passport'];

    if(!empty($_FILES['passport']['name']))
    {

        $passport =
        time().'_'.
        $_FILES['passport']['name'];

        move_uploaded_file(

            $_FILES['passport']['tmp_name'],

            '../uploads/'.$passport

        );
    }

    mysqli_query(

        $conn,

        "

        UPDATE supervisor_profiles

        SET

        passport='$passport',
        organization='$organization',
        position='$position',
        address='$address',
        bio='$bio'

        WHERE supervisor_id='$supervisor_id'

        "

    );

    header("Location: profile.php");
    exit();
}

?>

<div class="edit-profile-container">


<h2>Edit Profile</h2>

<form
method="POST"
enctype="multipart/form-data"
class="edit-profile-form">

    <img
    src="../uploads/<?php echo $profile['passport']; ?>"
    class="current-passport">

    <div class="form-group">

        <label>Change Passport</label>

        <input
        type="file"
        name="passport">

    </div>

    <div class="form-group">

        <label>Organization</label>

        <input
        type="text"
        name="organization"
        value="<?php echo $profile['organization']; ?>">

    </div>

    <div class="form-group">

        <label>Position</label>

        <input
        type="text"
        name="position"
        value="<?php echo $profile['position']; ?>">

    </div>

    <div class="form-group">

        <label>Address</label>

        <textarea
        name="address"><?php echo $profile['address']; ?></textarea>

    </div>

    <div class="form-group">

        <label>Bio</label>

        <textarea
        name="bio"><?php echo $profile['bio']; ?></textarea>

    </div>

    <button
    type="submit"
    name="update_profile"
    class="update-btn">

        Update Profile

    </button>

</form>


</div>


<?php require_once 'footer.php'; ?>
