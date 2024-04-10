<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
session_start();
$obj = new stdClass();

if(!isset($_SESSION['user_email'])){
    $obj->message = "authentication failed";
    $obj->statusCode = $ERROR;
}else if(!isset($_GET['cartID'])){
    $obj ->message = "cart id is required";
    $obj ->statusCode = $ERROR;
}else{
//    remove item from cart
    $db = new \database\Database();
    $q = "DELETE FROM cart WHERE idcart = :cartID AND user_email = :user_email";
    $db ->query($q);
    $db ->bind(':cartID', $_GET['cartID']);
    $db ->bind(':user_email', $_SESSION['user_email']);
    $db ->execute();
    $obj->statusCode = $SUCCESS;
    $obj->message = "item removed from cart";
}

echo json_encode($obj);