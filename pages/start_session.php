<?php
    //Start session  management
    session_start();
    
    //Set a session variable
    $_SESSION["staff_email"] = 'FR2930';

    //Output result
    echo 'Session started. username=' . $_SESSION["staff_email"];
    