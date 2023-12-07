<?php
    session_start();

    require_once __DIR__ . '/vendor/autoload.php';//this is the path to the vendor folder
    $m = new MongoDB\Client("mongodb://localhost:27017");//connecting to the database
        
    // selecting database
    $db = $m->Glassed;//Glassed is the database name

    
// Include config file
//require_once "config.php";

echo "Trying to Record updated successfully";
// Check if form is submitted
//if(isset($_POST['update'])) {
    echo "Trying to Record updated successfully";
    $bulk = new MongoDB\Driver\BulkWrite;
    $id = $_POST['id'];
    $product_name = $_POST['name'];
    $product_description = $_POST['description'];
    $product_price = $_POST['price'];
    //$img_src = $_POST['img_src'];
    
    $updateOption = [
        "product_name" => $product_name,
        "product_description" => $product_description,
        "product_price" => $product_price
    ];
    //Insert the new customer into the database
    $filterOption = ["product_name" => $product_name];//new \MongoDB\BSON\ObjectID($_SESSION['loggedInUserId'])];
    $insertResult = $db->Product->updateOne($filterOption,['$set' => $updateOption]);
    echo "ok";
/*
    $bulk->update(
        ['_id' => new MongoDB\BSON\ObjectId($id)],
        ['$set' => [
            'product_name' => $product_name,
            'product_description' => $product_description,
            'product_price' => $product_price,
            //'img_src' => $img_src
        ]]
    );

    $result = $collection->executeBulkWrite('Glassed_.Product', $bulk);
    header("Location: index.php");
    echo "Record updated successfully";
//}
*/
?>
