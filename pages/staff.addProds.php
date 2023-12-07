<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php';
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client);

//Select a database name (GlassedDB)
$db = $mongoClient->Glassed;

//Select a collection (name of collection eg: products, customers, staff)
$collection = $db->Product;

//Extract the data that was sent to the server
// $product_ID= filter_input(INPUT_POST, 'product_ID', FILTER_SANITIZE_STRING);
$product_name= filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
$product_description = filter_input(INPUT_POST, 'product_description', FILTER_SANITIZE_STRING);
$product_price = intval(filter_input(INPUT_POST, 'product_price', FILTER_SANITIZE_STRING));
$img_src = "../imgs/". filter_input(INPUT_POST, 'imageToUpload', FILTER_SANITIZE_STRING);
echo $product_name;
echo $product_description;
echo $product_price;
echo $img_src;
//Convert to PHP array
$dataArray = [
   // "product_ID" => $product_ID
    "product_name" => $product_name, 
    "product_description" => $product_description, 
    "product_price" => $product_price,
    "img"=>$img_src
 ];

//Add the new product to the database
$insertResult = $collection->insertOne($dataArray);
    
//Echo result back to user
if($insertResult->getInsertedCount()==1){
    echo 'Product added.';
    echo ' New document id: ' . $insertResult->getInsertedId();
}
else {
    echo 'Error adding Product';
}