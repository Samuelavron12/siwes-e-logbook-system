
<?php

require_once 'header.php';
require_once '../config/db.php';
$supervisor_id = $_SESSION['user_id'];

$selected_student = isset($_GET['student'])
? $_GET['student']
: 0;

/* ASSIGNED STUDENTS */

$students = mysqli_query(

    $conn,

    "

    SELECT

    u.user_id,
    u.full_name,
    u.last_login
    FROM student_supervisors ss

    JOIN users u

    ON ss.student_id = u.user_id

    WHERE ss.supervisor_id = '$supervisor_id'

    ORDER BY u.full_name ASC

    "

);
?>

<div class="chat-container">

    <!-- LEFT SIDE -->

    <div class="chat-users">

        <h3>Students</h3>

        <?php while($stu = mysqli_fetch_assoc($students)): ?>
            <?php

            $last = strtotime($stu['last_login']);

            $is_online =

            (time() - $last) < 300;

            ?>
            <a
                class="student-link"
                href="messages.php?student=<?php echo $stu['user_id']; ?>">

                    <?php echo $stu['full_name']; ?>

                    <span class="<?php echo $is_online ? 'online' : 'offline'; ?>"> <?php echo $is_online ? 'Online' : 'Offline'; ?> </span>

            </a>

        <?php endwhile; ?>

    </div>

    <!-- RIGHT SIDE -->

    <div class="chat-box">

        <?php if($selected_student): ?>

            <?php

            mysqli_query(

                $conn,

                "

                UPDATE messages

                SET is_read='1'

                WHERE receiver_id='$supervisor_id'

                AND sender_id='$selected_student'

                "

            );

            $messages = mysqli_query(

                $conn,

                "

                SELECT *

                FROM messages

                WHERE

                (

                    sender_id='$supervisor_id'

                    AND

                    receiver_id='$selected_student'

                )

                OR

                (

                    sender_id='$selected_student'

                    AND

                    receiver_id='$supervisor_id'

                )

                ORDER BY created_at ASC

                "

            );

            ?>

            <div class="chat-messages">

                <?php while($msg = mysqli_fetch_assoc($messages)): ?>

                    <?php

                    $mine =
                    $msg['sender_id']
                    ==
                    $supervisor_id;

                    ?>

                    <div class="message-row <?php echo $mine ? 'sent' : 'received'; ?>">

                        <div class="message-bubble">

                            <?php echo nl2br($msg['message']); ?>
                            <?php if(!empty($msg['attachment'])): ?>

                                <?php

                                $file = $msg['attachment'];

                                $ext = strtolower(

                                    pathinfo(

                                        $file,

                                        PATHINFO_EXTENSION

                                    )

                                );

                                ?>

                                <?php if(
                                    $ext == 'jpg' ||
                                    $ext == 'jpeg' ||
                                    $ext == 'png' ||
                                    $ext == 'gif' ||
                                    $ext == 'webp'
                                ): ?>

                                    <div class="chat-image">

                                    <a
                                        href="../uploads/messages/<?php echo $file; ?>"
                                        target="_blank">

                                            <img

                                            src="../uploads/messages/<?php echo $file; ?>"

                                            alt="attachment">

                                        </a>
                                    </div>

                                <?php else: ?>

                                    <a class="attachment-link" href="../uploads/messages/<?php echo $file; ?>" target="_blank"> Download File</a>

                                <?php endif; ?>

                            <?php endif; ?>

                            <small>

                                <?php echo date(

                                    "d M Y h:i A",

                                    strtotime($msg['created_at'])

                                ); ?>

                            </small>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

            <form

            action="send-message.php"

            method="POST"

            class="chat-form">

                <input

                type="hidden"

                name="receiver_id"

                value="<?php echo $selected_student; ?>">

                <textarea

                name="message"

                required

                placeholder="Enter Text Here"></textarea>

                <button type="submit">

                    Send

                </button>

            </form>

        <?php else: ?>

            <div class="empty-chat">

                Select a student to start chatting.

            </div>

        <?php endif; ?>

    </div>

</div>

<?php require_once 'footer.php'; ?>