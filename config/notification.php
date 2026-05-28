<?php

function createNotification(
    $conn,
    $user_id,
    $message
){

    $sql = "
        INSERT INTO notifications(
            user_id,
            message
        )

        VALUES(
            '$user_id',
            '$message'
        )
    ";

    mysqli_query($conn, $sql);
}
?>