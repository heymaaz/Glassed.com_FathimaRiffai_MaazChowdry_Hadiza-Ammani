<?php
    session_start();
    $intPid = filter_input(INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT);
    //$intQuantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
    if(isset($_SESSION['cart'])){
        $_SESSION['cart'][$intPid]++;
    }

?>
