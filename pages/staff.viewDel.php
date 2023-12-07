<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';

//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database
$db = $mongoClient->Glassed;

//Extract ID from POST data
$OrderID = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

//Build PHP array with delete criteria
$deleteCriteria = [
    "customer_id" => $OrderID
  
];

//Delete the order document
$deleteRes = $db->Order->deleteOne($deleteCriteria);

//Echo result back to user
if ($deleteRes->getDeletedCount() == 1) {
    echo 'Order deleted successfully.';
} else {
    echo 'Error deleting order';
}
