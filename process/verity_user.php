<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
$obj = new stdClass();
session_start();

function userIsExist($email,$password,$vc){
    $db = new \database\Database();
    $sql = "SELECT * FROM user  WHERE email = :email AND password = :password AND vc = :vc";
    $db->query($sql);
    $db->bind(":email", $email);
    $db->bind(":password", $password);
    $db->bind(":vc", $vc);
    $result = $db->resultSet();
    if (count($result) > 0) {
        return true;
    } else {
        return false;
    }

}

function activateUser($email){
    $db = new \database\Database();
    $sql = "UPDATE `user` SET `is_verified`=1 WHERE  `email`=:email";
    $db->query($sql);
    $db->bind(":email", $email);
    $db->execute();
    return true;
}
if(!isset($_SESSION['user_email'])){
    $obj->message = "Invalid Request";
    $obj->statusCode = $ERROR;
}else if(!isset($_SESSION['user_password'])){
    $obj->message = "Invalid Request";
    $obj->statusCode = $ERROR;
}else if(!isset($_POST['vc'])){
    $obj->message = "Please Enter Verification Code";
    $obj->statusCode = $ERROR;


}else{
    $email = $_SESSION['user_email'];
    $password = $_SESSION['user_password'];
    $vc = $_POST['vc'];
    if(!userIsExist($email,$password,$vc)){
        $obj->message = "Invalid Verification Code";
        $obj->statusCode = $ERROR;
    }else{
        activateUser($email);
        $obj->message = "Account Activated";
        $obj->statusCode = $SUCCESS;


    }
}


echo  json_encode($obj);