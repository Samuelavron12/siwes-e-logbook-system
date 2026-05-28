<?php

require 'config/mail.php';

if(sendOTP("avron232@gmail.com", 4821)){

    echo "Email Sent Successfully";

} else {

    echo "Email Failed";

}
?>