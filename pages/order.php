<?php
    session_start();
    $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_SANITIZE_STRING);
    $order_total = filter_input(INPUT_POST, 'order_total', FILTER_SANITIZE_NUMBER_INT);
    //$product_id_qty = filter_input(INPUT_POST, 'product_id_qty', FILTER_SANITIZE_STRING);
    $product_id_qty=json_decode($_POST['product_id_qty']);


    require_once __DIR__ . '/vendor/autoload.php';//this is the path to the vendor folder
    $m = new MongoDB\Client("mongodb://localhost:27017");//connecting to the database
        
    // selecting database
    $db = $m->Glassed;//Glassed is the database name
    //create a new order
    $newOrder = [
        "customer_id" => $customer_id,
        "order_total" => $order_total,
        "product_id_qty" => $product_id_qty
    ];
    //Insert the new order into the database
    $insertResult = $db->Order->insertOne($newOrder);
    //Check if the insert was successful
    if($insertResult->getInsertedCount() != 1){
      //The insert was not successful
      echo "Insert failed";
      return;
    }
    for($i=0;$i<count($_SESSION['cart']);$i++){//empties the cart
        $_SESSION['cart'][$i] = 0;
    }
    echo "ok";//if the insert was successful

    //Redirect to the home page
    //header('Location: index.html');
?>