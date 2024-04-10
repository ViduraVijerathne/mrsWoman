<?php
global $SUCCESS, $PAYMENT_PROCESSING;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
require_once "../const/orderStatus.php";
session_start();
$obj = new stdClass();

if(!isset($_SESSION['user_email'])){
    $obj->message = "Auth failed";
    $obj->statusCode = $ERROR;
}else if(!isset($_GET['orderID'])){
    $obj ->message = "order id is required";
    $obj ->statusCode = $ERROR;
}else{
    $db2 = new \database\Database();
    $query2 = "INSERT INTO `order_status` (`status`, `date_time`, `order_order_id`) VALUES (:status, :dateTime,:orderID);";
    $db2->query($query2);
    $db2->bind(":status", $PAYMENT_PROCESSING);
    $db2->bind(":dateTime", date("Y-m-d H:i:s"));
    $db2->bind(":orderID", $_GET['orderID']);
    $db2->execute();
    $obj ->message = "Successfully";
    $obj ->statusCode = $SUCCESS;
}



echo json_encode($obj);
