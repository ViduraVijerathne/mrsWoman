<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";

session_start();
$obj = new stdClass();

if(!isset($_SESSION['user_email'])){
    $obj -> message = "Login Required";
    $obj -> statusCode = $ERROR;
}else if(!isset($_POST['productID'])){
    $obj -> message = "productID is required";
    $obj -> statusCode = $ERROR;
}else{
    $db  = new \database\Database();
    $q = "SELECT * FROM whish_list WHERE whish_list.user_email = :email AND whish_list.product_product_id = :pid";
    $db ->query($q);
    $db -> bind(':email', $_SESSION['user_email']);
    $db -> bind(':pid', $_POST['productID']);
    $result = $db -> resultSet();
    if(count($result) > 0){
        $q = "DELETE FROM whish_list WHERE user_email = :email AND product_product_id = :pid";
        $db->query($q);
        $db->bind(':email', $_SESSION['user_email']);
        $db->bind(':pid', $_POST['productID']);
        $db->execute();
        $obj -> message = "Successfully removed from wishlist";
        $obj ->statusCode = $SUCCESS;

    }else{
        $q = "INSERT INTO whish_list (user_email, product_product_id) VALUES (:email, :pid)";
        $db->query($q);
        $db->bind(':email', $_SESSION['user_email']);
        $db->bind(':pid', $_POST['productID']);
        $db->execute();
        $obj -> message = "Successfully Add to wishlist";
        $obj ->statusCode = $SUCCESS;
    }
}

echo  json_encode($obj);