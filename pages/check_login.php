<?php
    session_start();
    if(array_key_exists('loggedInUserEmail', $_SESSION)) {
      //User is logged in
      echo "ok";
    } else {
      //User is not logged in
      echo "Not logged in";
    }
?>
