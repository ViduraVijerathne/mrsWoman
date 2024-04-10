<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
$obj = new stdClass();
if (!isset($_GET["pid"])) {
//    length validation max 100
    $obj->message = "product ID is missing";
    $obj->statusCode = $ERROR;
} else if (!isset($_GET["status"])) {
    $obj->message = " product active Status is missing";
    $obj->statusCode = $ERROR;

}else {
    $db = new \database\Database();
    $q = "UPDATE product SET is_active = :status WHERE product_id = :pid";

    $db->query($q);
    $db->bind(":status",$_GET["status"]);
    $db->bind(":pid",$_GET["pid"]);
    $db->execute();
    $obj->message = "Successfully updated Product Active Status";
    $obj->statusCode = $SUCCESS;
}


echo json_encode($obj);



