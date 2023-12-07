<?php
    
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);


    require_once __DIR__ . '/vendor/autoload.php';//this is the path to the vendor folder
    $m = new MongoDB\Client("mongodb://localhost:27017");//connecting to the database
        
    // selecting database
    $db = $m->Glassed;//Glassed is the database name
    //Create a PHP array with our search criteria
    $findCriteria = [
        "customer_email" => $email
    ];
    //Find all of the customers that match  this criteria
    $resultArray = $db->Customer->find($findCriteria)->toArray();
    //If we have found a customer
    if(count($resultArray) >= 1) {
        //More than one customer was found
        echo "customer exists";
        return;
    }
    //create a new customer
    $newCustomer = [
        "customer_name" => $name,
        "customer_email" => $email,
        "customer_password" => $password,
        "customer_phone_no" => $phone,
        "customer_address" => $address
    ];
    //Insert the new customer into the database
    $insertResult = $db->Customer->insertOne($newCustomer);
    //Check if the insert was successful
    if($insertResult->getInsertedCount() != 1){
      //The insert was not successful
      echo "Insert failed";
      return;
    }
    echo "ok";
    //Redirect to the home page
    //header('Location: index.html');
?>