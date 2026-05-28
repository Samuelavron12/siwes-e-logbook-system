<?php

require_once 'config/db.php';

if($conn){
    echo "Database Connected Successfully  go on with building  youy system";
} else {
    echo "Database Connection Failed";
}

?>