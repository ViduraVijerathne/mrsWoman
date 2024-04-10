<?php
global $SUCCESS, $PAYMENT_DONE, $PLACE_ORDER;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
require_once '../const/auth.php';
require_once  '../const/orderStatus.php';
$obj = new stdClass();
if(isAdmin()){
    if(!isset($_GET['orderID'])){
        $obj->message = "order ID is required";
        $obj->statusCode = $ERROR;
    }else{
        $db2 = new \database\Database();
        $query2 = "INSERT INTO `order_status` (`status`, `date_time`, `order_order_id`) VALUES (:status, :dateTime,:orderID);";
        $db2->query($query2);
        $db2->bind(":status", $PLACE_ORDER);
        $db2->bind(":dateTime", date("Y-m-d H:i:s"));
        $db2->bind(":orderID", $_GET['orderID']);
        $db2->execute();
        $obj -> message  = "Success !";
        $obj -> statusCode = $SUCCESS;

    }

}else{
    $obj -> message  = "Authentication failed";
    $obj -> statusCode = $ERROR;
}



echo json_encode($obj);