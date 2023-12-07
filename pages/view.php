<?php
//connect to MongoDB
$mongo = new MongoDB\Driver\Manager("mongodb://localhost:27017");

//query to get all products from the Product collection
$query = new MongoDB\Driver\Query([]);

//execute the query
$rows = $mongo->executeQuery("Glassed.Product", $query);

//create an empty array to store the products
$products = array();

//iterate through the result set and add each product to the array
foreach ($rows as $row) {
    $product = array(
        '_id' => (string)$row->_id,
        'product_name' => $row->product_name,
        'product_description' => $row->product_description,
        'product_price' => $row->product_price
    );
    array_push($products, $product);
}

//convert the array to JSON string and return it
echo json_encode($products);
?>
