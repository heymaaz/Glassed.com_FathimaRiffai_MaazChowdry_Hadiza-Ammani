<?php
    //Start session management
    session_start();

   //This gets the values of the email and password fields sent from the form using the HTTP POST method.
   //The filter_input function is used to sanitize the input to reduce the chances of SQL injection attacks.
    $staff_email= filter_input(INPUT_POST, 'staff_email', FILTER_SANITIZE_STRING);
    $staff_password = filter_input(INPUT_POST, 'staff_password', FILTER_SANITIZE_STRING);    
    //echo  $staff_email;
    //echo    $staff_password;

    //establishes a connection to the MongoDB database and selects the Glassed database.
	require __DIR__ . '/vendor/autoload.php';//Include libraries
	$mongoClient = (new MongoDB\Client);//Create instance of MongoDB client
	$db = $mongoClient->Glassed;
	
    //Create a PHP array with our search criteria
    //Finds all of the customers that match this criteria
    //This creates a search criteria array for finding a specific staff member using their email address. 
    //The $findCriteria array is used to search the Staff collection in the Glassed database. 
    $findCriteria = [ "staff_email" => $staff_email ];


   //The results are returned as an array and assigned to $resultArray.
    $resultArray = $db->Staff->find($findCriteria)->toArray();

    //Check that there is exactly one customer
    //This checks if the $resultArray has only one item. If there are no items, 
    //an error message is displayed. If there is more than one item, it indicates a database error.
    if(count($resultArray) == 0){
        echo 'Staff email not found';
        return;
    }
    else if(count($resultArray) > 1){
        echo 'Database error: Multiple staff members have same email address.';
        return;
    }
   
    //Get customer and check password
    //This assigns the first (and only) item in the $resultArray to the $Staff variable. 
    //It then checks if the provided password matches the password in the $Staff array.
    // If they don't match, an error message "Password incorrect" is displayed.
    $Staff = $resultArray[0];
    if($Staff['staff_password'] != $staff_password){
        echo 'Password incorrect.';
        return;
    }
        
    //Start session for this user
    //This sets a session variable named loggedInUserEmail to the value of the $staff_email variable.
    // This allows the server to keep track of the user who is currently logged in.
    $_SESSION['loggedInUserEmail'] = $staff_email;
    
    //Inform web page that login is successful
    //This displays the string 'ok' to indicate that the login was successful. 
    //echo 'ok';  
    //echo $_SESSION['loggedInUserEmail'];

    //It then includes the 'staff.addProds.html' file, which is the next page that the user 
    //will see after logging in.
    include 'staff.addProds.html';
    ?>