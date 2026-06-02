<?php

session_start();

require_once '../config/db.php';

$sender_id = $_SESSION['user_id'];

$receiver_id = $_POST['receiver_id'];

$message = mysqli_real_escape_string(

    $conn,

    $_POST['message']

);

$file_name = '';

if(!empty($_FILES['attachment']['name'])){

    $file_name =
    time().'_'.
    $_FILES['attachment']['name'];

    move_uploaded_file(

        $_FILES['attachment']['tmp_name'],

        "../uploads/messages/".$file_name

    );
}





mysqli_query(

    $conn,

    "

    INSERT INTO messages(
    sender_id,
    receiver_id,
    message,
    attachment
    )

    VALUES(

    '$sender_id',
    '$receiver_id',
    '$message',
    '$file_name'

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

        'You received a new message from a student.'

    )

    "

);

header("Location: messages.php");

exit();