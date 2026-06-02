<?php

require_once 'header.php';
require_once '../config/db.php';

$student_id = $_SESSION['user_id'];

/* FETCH SUPERVISOR */
$supervisor_query = mysqli_query($conn, "
    SELECT u.user_id, u.full_name
    FROM student_supervisors ss
    JOIN users u ON ss.supervisor_id = u.user_id
    WHERE ss.student_id = '$student_id'
    LIMIT 1
");

$supervisor = mysqli_fetch_assoc($supervisor_query);

$supervisor_id = $supervisor['user_id'] ?? null;

?>

<!-- ================= TOP BAR ================= -->
<div class="chat-topbar">
    <?php if($supervisor): ?>
        <div class="supervisor-name">
            <?php echo $supervisor['full_name']; ?>
        </div>
    <?php endif; ?>
</div>

<!-- ================= CHAT PAGE ================= -->
<div class="chat-page">

<?php if($supervisor): ?>

<?php

/* MARK AS READ */
mysqli_query($conn, "
    UPDATE messages
    SET is_read='1'
    WHERE receiver_id='$student_id'
    AND sender_id='$supervisor_id'
");

/* GET MESSAGES */
$messages = mysqli_query($conn, "
    SELECT *
    FROM messages
    WHERE 
    (sender_id='$student_id' AND receiver_id='$supervisor_id')
    OR
    (sender_id='$supervisor_id' AND receiver_id='$student_id')
    ORDER BY created_at ASC
");

?>

<!-- ================= MESSAGES ================= -->
<div class="chat-messages">

    <?php while($msg = mysqli_fetch_assoc($messages)): ?>

        <?php $mine = $msg['sender_id'] == $student_id; ?>

        <div class="message-row <?php echo $mine ? 'sent' : 'received'; ?>">

            <div class="message-bubble">

                <?php echo nl2br($msg['message']); ?>

                <?php if(!empty($msg['attachment'])): ?>

                    <?php
                    $file = $msg['attachment'];
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    ?>

                    <?php if(in_array($ext, ['jpg','jpeg','png','gif','webp'])): ?>

                        <div class="chat-image">
                            <img src="../uploads/messages/<?php echo $file; ?>" alt="">
                        </div>

                    <?php else: ?>

                        <a href="../uploads/messages/<?php echo $file; ?>" target="_blank">
                            Download File
                        </a>

                    <?php endif; ?>

                <?php endif; ?>

                <small>
                    <?php echo date("d M Y h:i A", strtotime($msg['created_at'])); ?>
                </small>

            </div>
        </div>

    <?php endwhile; ?>

</div>

<!-- ================= INPUT FORM ================= -->
<form action="send-message.php"
      method="POST"
      enctype="multipart/form-data"
      class="chat-form">

    <input type="hidden" name="receiver_id" value="<?php echo $supervisor_id; ?>">

    <input type="file" name="attachment">

    <textarea name="message" placeholder="Enter Text Here"></textarea>

    <button type="submit">Send</button>

</form>

<?php else: ?>

<div class="empty-chat">
    No supervisor assigned yet.
</div>

<?php endif; ?>

</div>

<?php require_once 'footer.php'; ?>