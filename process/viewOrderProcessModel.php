<?php
global $SUCCESS, $PAYMENT_DONE, $PLACE_ORDER;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
require_once '../const/auth.php';
require_once  '../const/orderStatus.php';
$obj = new stdClass();
if(isAdmin()){
    if(!isset($_GET['oid'])){
        $obj->message = "order ID is required";
        $obj->statusCode = $ERROR;
    }else{
        $db2 = new \database\Database();
        $query2 = "SELECT * FROM order_status WHERE order_status.order_order_id = :id ORDER BY order_status.date_time ASC ";
        $db2->query($query2);
        $db2->bind(":id", $_GET['oid']);
        $results = $db2->resultSet();
        $arr = array();
        for($i = 0; $i < count($results); $i++){
            $itemObj = new stdClass();

            $item = $results[$i];
            $itemObj->status = $item['status'];
            $dateTime = new DateTime($item['date_time']);
            // Format the DateTime object to the desired format
            $itemObj->date_time = $dateTime->format('Y-m-d H:i');
            $itemObj->order_order_id = $item['order_order_id'];
            $itemObj->id = $item['idorder_status'];
            $arr[] = $itemObj;
        }
        $obj->statusCode = $SUCCESS;
        $obj->message =$arr ;
    }

}else{
    $obj -> message  = "Authentication failed";
    $obj -> statusCode = $ERROR;
}



echo json_encode($obj);
//$obj->items = '';


//ob_start();



//$obj->items .= ob_get_clean();
//echo  json_encode($obj);


?>