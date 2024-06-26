<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
$obj = new stdClass();

function validateEmail($email) {
    // First, check if the email address is not empty
    if (empty($email)) {
        return false;
    }

    // Check if the email address has a valid format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // Check if the domain part of the email address has valid DNS records
    $domain = explode('@', $email)[1];
    if (!checkdnsrr($domain, 'MX')) {
        return false;
    }

    // If all checks pass, return true
    return true;
}
function validatePassword($password) {
    // Check if password length is between 5 and 12 characters
    $passwordLength = strlen($password);
    if ($passwordLength < 5 || $passwordLength > 12) {
        return false;
    }

    // If all checks pass, return true
    return true;
}
function sendVC() {
    // Generate a random number within the specified range
    $min = 100000;
    $max = 999999;
    return mt_rand($min, $max);
}
function validateName($name){
    // Check if password length is between 3 and 12 characters
    $nameLength = strlen($name);
    if ($nameLength < 3 || $nameLength > 25 ) {
        return false;
    }

    // If all checks pass, return true
    return true;
}

function checkEmailIsExist($email){
    $db = new \database\Database();
    $sql = "SELECT * FROM user WHERE email = :email";
    $db->query($sql);
    $db->bind(":email", $email);
    $result = $db->resultSet();
    if (count($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function validateMobile($mobile){
// Check if mobile number contains only numeric characters
    if (!ctype_digit($mobile)) {
        return false;
    }

    // Check if mobile number length is 10
    if (strlen($mobile) !== 10) {
        return false;
    }

    // If all checks pass, return true
    return true;
}

function signup($email,$password,$name,$mobile,$vc){
    $db = new \database\Database();
    $sql = "INSERT INTO user (email,password,name,mobile,vc) VALUES (:email,:password,:name,:mobile,:vc)";
    $db->query($sql);
    $db->bind(":email", $email);
    $db->bind(":password", $password);
    $db->bind(":name", $name);
    $db->bind(":mobile", $mobile);
    $db->bind(":vc", $vc);
    $result = $db->execute();
    if ($result) {
        return true;
    } else {
        return false;
    }
}

if(!isset($_POST['email'])){
    $obj->message = "Please enter a valid email address";
    $obj->statusCode = $ERROR;
}elseif (!validateEmail($_POST['email'])){
    $obj->message = "Please enter a valid email address";
    $obj->statusCode = $ERROR;
}elseif (!isset($_POST['password'])){
    $obj->message = "Please enter a  password";
    $obj->statusCode = $ERROR;
}elseif(!validatePassword($_POST['password'])){
    $obj->message = "password must be at least 5 characters and maximum 12";
    $obj->statusCode = $ERROR;
}elseif($_POST['retypePassword'] != $_POST['password']){
    $obj->message = "password and retype password must be the same";
    $obj->statusCode = $ERROR;
}elseif(!isset($_POST['name'])){
    $obj->message = "please enter a name";
    $obj->statusCode = $ERROR;
}elseif(!validateName($_POST['name'])){
    $obj->message = "name must be at least 3 characters and maximum 25";
    $obj->statusCode = $ERROR;
}elseif(!validateMobile($_POST['mobile'])){
    $obj->message = "please enter a valid mobile number";
    $obj->statusCode = $ERROR;


}else if(checkEmailIsExist($_POST['email'])){
    $obj->message = "email is already exist";
    $obj->statusCode = $ERROR;
}
else{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $vc = sendVC();
    if(signup($email,$password,$name,$mobile,$vc)){
        $obj->message = "Successfully registered";
        session_start();
        $_SESSION['unverified_user_email'] = $email;
        $_SESSION['unverified_user_password'] = $password;
        $obj->statusCode = $SUCCESS;
    }else{
        $obj->message = "Something went wrong";
        $obj->statusCode = $ERROR;
    }



}



echo  json_encode($obj);