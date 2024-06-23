<?php
global $ERROR,$PAYMENT_PROCESSING,$PAYMENT_DONE;
require_once '../const/statesCodes.php';
require_once '../const/auth.php';
require_once "../database/database.php";
require_once "../const/orderStatus.php";
global $ORDERING;
session_start();
$obj = new stdClass();
$obj->message = "done";
$obj->statusCode = 1;
$obj->body = "success";
if(isset($_SESSION['admin_email'])){

    unset($_SESSION['admin_email']);
}
if(isset($_SESSION['admin_password'])){

    unset($_SESSION['admin_password']);
}
if(isset($_SESSION['user_email'])){

    unset($_SESSION['user_email']);
}
if(isset($_SESSION['user_password'])){

    unset($_SESSION['user_password']);
}
echo json_encode($obj);

?>