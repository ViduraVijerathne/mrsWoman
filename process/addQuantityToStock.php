<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
require_once "../const/auth.php";
$obj = new stdClass();
if(isAdmin()){
    if (!isset($_POST["id"])) {
        $obj->message = "stock id is missing";
        $obj->statusCode = $ERROR;
    }else if (!isset($_POST["qty"])) {
        $obj->message = "stock qty is missing";
        $obj->statusCode = $ERROR;
    }else if($_POST['qty']<=0){
        $obj->message = "quantity is invalid";
        $obj->statusCode = $ERROR;
    }else{
        $db = new \database\Database();
        $q = "UPDATE `stock` SET `qty`= `qty`+:qty WHERE  `stock_id` = :stockID";
        $db->query($q);
        $db->bind("qty",$_POST['qty']);
        $db->bind("stockID",$_POST['id']);
        $db->execute();
        $obj->message = "done";
        $obj->statusCode = $SUCCESS;
    }
}else {
    $obj->message = "authentication failed!";
    $obj->statusCode = $ERROR;
}

echo json_encode($obj);