<?php
global $SUCCESS, $PAYMENT_DONE;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
require_once '../const/auth.php';
require_once  '../const/orderStatus.php';
$obj = new stdClass();
function substractFromStock($OrderID){
    $db = new \database\Database();
    $sql = "SELECT * FROM order_has_stock WHERE order_order_id = :OrderID";
    $db->query($sql);
    $db->bind(":OrderID", $OrderID);
    $OrderStocks = $db->resultSet();
    foreach ($OrderStocks as $OrderStock){
        $stockID = $OrderStock['stock_stock_id'];
        $quantity = $OrderStock['order_qty'];

        $sql = "UPDATE stock SET stock.qty = stock.qty - :quantity WHERE stock.stock_id = :stockID";
        $db2 = new \database\Database();
        $db2->query($sql);
        $db2->bind(":stockID", $stockID);
        $db2->bind(":quantity", $quantity);
        $db2->execute();
    }

}
if(isAdmin()){
    if(!isset($_GET['orderID'])){
        $obj->message = "order ID is required";
        $obj->statusCode = $ERROR;
    }else{
        $db2 = new \database\Database();
        $query2 = "INSERT INTO `order_status` (`status`, `date_time`, `order_order_id`) VALUES (:status, :dateTime,:orderID);";
        $db2->query($query2);
        $db2->bind(":status", $PAYMENT_DONE);
        $db2->bind(":dateTime", date("Y-m-d H:i:s"));
        $db2->bind(":orderID", $_GET['orderID']);
        $db2->execute();
        $obj -> message  = "Success !";
        $obj -> statusCode = $SUCCESS;

        substractFromStock($_GET['orderID']);
    }

}else{
    $obj -> message  = "Authentication failed";
    $obj -> statusCode = $ERROR;
}



echo json_encode($obj);