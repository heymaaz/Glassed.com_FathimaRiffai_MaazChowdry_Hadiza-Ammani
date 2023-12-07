<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';

//Create instance of MongoDB client
$mongoClient = new MongoDB\Client;

//Select a database
$db = $mongoClient->Glassed;

//Handle create (insert) operation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //Extract order data from POST request
  $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_SANITIZE_STRING);
  $order_total = filter_input(INPUT_POST, 'order_total', FILTER_SANITIZE_STRING);
  $product_id_qty = filter_input(INPUT_POST, 'product_id_qty', FILTER_SANITIZE_STRING);
  
  //Create new order document
  $insertResult = $db->Order->insertOne([
    'customer_id' => $customer_id,
    'order_total' => $order_total,
    'product_id_qty' => $product_id_qty
  ]);
  
  //Return the ID of the newly created order
  echo $insertResult->getInsertedId();
}

//Handle read (get) operation
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  //Get all orders from database
  $orders = $db->Order->find();
  
  //Convert orders to array of associative arrays
  $orderArray = iterator_to_array($orders);
  $orderJson = json_encode($orderArray);
  
  //Return orders as JSON response
  header('Content-Type: application/json');
  echo $orderJson;
}

//Handle update operation
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  //Extract order data from PUT request
  parse_str(file_get_contents("php://input"), $putData);
  $orderID = $putData['id'];
  $customer_id = $putData['customer_id'];
  $order_total = $putData['order_total'];
  $product_id_qty = $putData['product_id_qty'];
  
  //Build update query
  $updateResult = $db->Order->updateOne(
    ['_id' => new MongoDB\BSON\ObjectID($orderID)],
    ['$set' => [
     // 'customer_id' => $customer_id,
      'order_total' => $order_total,
      'product_id_qty' => $product_id_qty
    ]]
  );
  
  //Return success or error message
  if ($updateResult->getModifiedCount() === 1) {
    echo 'Order updated successfully.';
  } else {
    echo 'Error updating order.';
  }
}

//Handle delete operation
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  //Extract order ID from DELETE request
  $orderID = filter_input(INPUT_GET, '_id', FILTER_SANITIZE_STRING);
  
  //Build delete criteria 
  $deleteCriteria = [
    "_id" => new MongoDB\BSON\ObjectID($orderID)
  ];
  
  //Delete the order document
  $deleteRes = $db->Order->deleteOne($deleteCriteria);
  
  //Return success or error message
  if ($deleteRes->getDeletedCount() === 1) {
    echo 'Order deleted successfully.';
  } else {
    echo 'Error deleting order.';
  }
}
