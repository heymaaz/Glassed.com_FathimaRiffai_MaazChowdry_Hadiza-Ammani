<?php
    //start session management
    session_start();
    //remove all session variables
    session_unset();
    //destroy the session
    session_destroy();
    //echo a message to say the session has been destroyed
    echo "ok";
?>