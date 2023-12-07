<?php
    session_start();
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);


    require_once __DIR__ . '/vendor/autoload.php';//this is the path to the vendor folder
    $m = new MongoDB\Client("mongodb://localhost:27017");//connecting to the database
        
    // selecting database
    $db = $m->Glassed;//Glassed is the database name
    //Create a PHP array with our search criteria
    $findCriteria = [
        "customer_email" => $email//,
        //"password" => $password
    ];
    //Find all of the customers that match  this criteria
    $resultArray = $db->Customer->find($findCriteria)->toArray();
    //If we have found a customer
    if (count($resultArray) == 0) {
      //No customer was found
      echo "No customer found";
      return;
    }
    if(count($resultArray) > 1) {
        //More than one customer was found
        echo "More than one customer found";
        return;
    }
    //Get the first (and only) customer from the array
    $customer = $resultArray[0];
    //Check the password
    if($password!=$customer['customer_password']){
      //Password is incorrect
      echo "Incorrect password";
      return;
    }
    //Set the session variables
    $_SESSION['loggedInUserEmail'] = $email;
    $_SESSION['loggedInUserId'] = $customer['_id'];
    $_SESSION['loggedInUserName'] = $customer['customer_name'];
    $_SESSION['loggedInUserPhone'] = $customer['customer_phone_no'];
    $_SESSION['loggedInUserAddress'] = $customer['customer_address'];
    $_SESSION['loggedInUserPassword'] = $customer['customer_password'];
    
    $Prod = $db->Product->find([])->toArray();

    $_SESSION['array'] = array();
    for($i=0;$i<=count($Prod);$i++){
        $_SESSION['array'][$i] = 0;
    }
    $_SESSION['cart'] = array();//creates a session variable called cart to store the product quantity in the cart
    for($i=0;$i<=count($Prod);$i++){
      $_SESSION['cart'][$i] = 0;
    }
    /*
    $_SESSION['cart']['pid'] = array();
    $_SESSION['cart']['quantity'] = array();
    $_SESSION['cart']['price'] = array();
    $_SESSION['cart']['total'] = 0;
    $_SESSION['cart']['count'] = 0;
    */

    echo "ok";
    //Redirect to the home page
    //header('Location: index.html');
?>