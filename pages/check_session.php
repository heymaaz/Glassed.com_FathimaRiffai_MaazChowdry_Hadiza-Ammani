<?php
    //Start session management
    session_start();
    
    //Find out if session exists
    //Checks whether a session has been started and exists using the array_key_exists() function
    // and the $_SESSION superglobal array. If the session exists, it displays a message with the staff email stored in the 
    //$_SESSION array.
    if( array_key_exists("loggedInUserEmail", $_SESSION) ){
        echo 'Session in progress. staff_email=' . $_SESSION["staff_email"];
    }
    else{
        //If the session does not exist, it displays a message saying "Session not started".
        echo 'Session not started';
    }
    
    