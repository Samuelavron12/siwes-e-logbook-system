<?php

require_once 'header.php';
require_once '../config/db.php';

if(isset($_POST['publish']))
{
    $title = mysqli_real_escape_string(
        $conn,
        $_POST['title']
    );

    $message = mysqli_real_escape_string(
        $conn,
        $_POST['message']
    );

    $target = $_POST['target'];

    mysqli_query(

        $conn,

        "

        INSERT INTO announcements(

        title,
        message,
        target

        )

        VALUES(

        '$title',
        '$message',
        '$target'

        )

        "

    );

    $success = "Announcement Published";
}

$announcements = mysqli_query(

    $conn,

    "

    SELECT *

    FROM announcements

    ORDER BY announcement_id DESC

    "

);

?>

<div class="announcement-page">

    <h2>Announcements</h2>

    <?php if(isset($success)): ?>

    <div class="success-box">

        <?php echo $success; ?>

    </div>

    <?php endif; ?>

    <form method="POST">

        <input
        type="text"
        name="title"
        placeholder="Announcement Title"
        required>

        <textarea
        name="message"
        rows="5"
        placeholder="Announcement Message"
        required></textarea>

        <select name="target">

            <option value="all">
                Everyone
            </option>

            <option value="student">
                Students
            </option>

            <option value="supervisor">
                Supervisors
            </option>

        </select>

        <button
        type="submit"
        name="publish">

            Publish

        </button>

    </form>

    <hr>

    <?php while($row = mysqli_fetch_assoc($announcements)): ?>

    <div class="announcement-card">

        <h3>

            <?php echo $row['title']; ?>

        </h3>

        <small>

            Target:
            <?php echo ucfirst($row['target']); ?>

        </small>

        <p>

            <?php echo nl2br($row['message']); ?>

        </p>

        <small>

            <?php echo $row['created_at']; ?>

        </small>

    </div>

    <?php endwhile; ?>

</div>

<?php require_once 'footer.php'; ?>