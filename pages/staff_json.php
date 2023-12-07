<?php

//Include libraries
require __DIR__ . '/vendor/autoload.php'; //I am including the MongoDB PHP library,
    
//Create instance of MongoDB client
$mongoClient = (new MongoDB\Client); //I am creating an instance of the MongoDB client, 

//Select a database
$db = $mongoClient->Glassed; //selecting the database named "Glassed,"

// then Selecting a collection named Product
$collection = $db->Product;

//Test data - this would be a JSON string sent to the server and extracted from $_POST
//we're retrieving data from a POST request sent to the server. We're using the filter_input function 
//to sanitize the input data by removing any unwanted characters.
$product_ID= filter_input(INPUT_POST, 'product_ID', FILTER_SANITIZE_STRING);
$product_name= filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
$product_description = filter_input(INPUT_POST, 'product_description', FILTER_SANITIZE_STRING);
$product_price = filter_input(INPUT_POST, 'product_price', FILTER_SANITIZE_STRING);
$img_src = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_STRING);

//Convert JSON string to PHP  array. 'true' converts to array instead of PHP object.
//we're creating an array called $dataArray that contains the sanitized input data. The 
//$dataArray array is then decoded using json_decode and passed the input data, which creates a PHP array.
//The true argument passed to json_decode ensures that the array is returned as an associative array rather 
//than an object.
$dataArray = [
    "product_ID" => $product_ID,
    "product_name" => $product_name, 
    "product_description" => $product_description, 
    "product_price" => $product_price,
    "img"=>$img_src
 ];

 $dataArray = json_decode($product_ID,$product_name,$product_description, $img_src, true);

 //Add the new product to the database
 //we're inserting the $dataArray array into the MongoDB collection using the insertOne method. 
 //The result of the operation is stored in the $insertResult variable.
$insertResult = $collection->insertOne($ProductDataArray);
    
//Echo result back to user
//I am checking if the operation was successful using the getInsertedCount method of the $insertResult variable. 
//If the result is equal to 1, 
//this will print a success message along with the ID of the inserted document. Otherwise, there will be print an error message
if($insertResult->getInsertedCount()==1){
    echo 'New Product added.';
    echo ' New document id: ' . $insertResult->getInsertedId();
}
else {
    echo 'Error adding product';
}
