<?php

session_start();

require_once '../config/db.php';

$sender_id = $_SESSION['user_id'];

$receiver_id = $_POST['receiver_id'];

$message = mysqli_real_escape_string(

    $conn,

    $_POST['message']

);

mysqli_query(

    $conn,

    "

    INSERT INTO messages(

        sender_id,
        receiver_id,
        message

    )

    VALUES(

        '$sender_id',
        '$receiver_id',
        '$message'

    )

    "

);

/* NOTIFICATION */

mysqli_query(

    $conn,

    "

    INSERT INTO notifications(

        user_id,
        message

    )

    VALUES(

        '$receiver_id',

        'You received a new message from your supervisor.'

    )

    "

);

header(

    "Location: messages.php?student=".$receiver_id

);

exit();