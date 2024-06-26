<?php
global $SUCCESS, $NOT_VERIFIED;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
$obj = new stdClass();
session_start();
function sendVC($email) {
    // Generate a random number within the specified range
    $min = 100000;
    $max = 999999;
    $vc = mt_rand($min, $max);

    $db = new \database\Database();
    $query  = "UPDATE `user` SET `vc`=:vc WHERE  `email`=:email;";
    $db->query($query);
    $db->bind(":vc", $vc);
    $db->bind(":email", $email);
    $db->execute();

    return $vc;
}


function  alreadyExistUser($email) {
    $db = new \database\Database();
    $query  = "SELECT * FROM `user` WHERE `email`=:email;";
    $db->query($query);
    $db->bind(":email", $email);
    $res = $db->resultSet();
    if(count($res) == 1) {
        return true;
    }else{
        return false;
    }
}

//check user is exist and send  verification code
function step1()
{
    global $ERROR, $SUCCESS;
    $step1Obj = new stdClass();
    if(!isset($_POST['email'])){
        $step1Obj->message = "email is missing";
        $step1Obj->statusCode = $ERROR;
    }else if(alreadyExistUser($_POST['email'])){
        sendVC($_POST['email']);
        $_SESSION['forgotPasswordEmail'] = $_POST['email'];
        $step1Obj->message = "Verification code is send, check your email";
        $step1Obj->statusCode = $SUCCESS;
    }else{
        $step1Obj->message = "email already not exist";
        $step1Obj->statusCode = $ERROR;
    }
    return $step1Obj;
}

function step2(){
    global $ERROR, $SUCCESS;
    $step2Obj = new stdClass();
    if(!isset($_POST['vc'])){
        $step2Obj->message = "verification code is missing";
        $step2Obj->statusCode = $ERROR;
    }else if(!isset($_SESSION['forgotPasswordEmail'])){
        $step2Obj->message = "email is missing";
        $step2Obj->statusCode = $ERROR;
    }else {
        $db = new \database\Database();
        $query  = "SELECT * FROM `user` WHERE `vc`=:vc AND `email`=:email;";
        $db->query($query);
        $db->bind("vc", $_POST['vc']);
        $db->bind("email", $_SESSION['forgotPasswordEmail']);
        $res = $db->resultSet();
        if(count($res) == 1) {
            $_SESSION['verifiedForgotPasswordEmail'] = $_SESSION['forgotPasswordEmail'];
            unset($_SESSION['forgotPasswordEmail']);
            $step2Obj->message = "verification  is Success, create your new password";
            $step2Obj->statusCode = $SUCCESS;
        }else{
            $step2Obj->message = "verification code is incorrect";
            $step2Obj->statusCode = $ERROR;
        }

    }
    return  $step2Obj;

}

function  step3()
{
     global $ERROR, $SUCCESS;
     $step3Obj = new stdClass();
     if(!isset($_SESSION['verifiedForgotPasswordEmail'])){
         $step3Obj->message = "email is missing";
         $step3Obj->statusCode = $ERROR;
     }else if(!isset($_POST['password'])){
         $step3Obj->message = "password is missing";
         $step3Obj->statusCode = $ERROR;
     }else if(strlen($_POST['password']) < 6){
         $step3Obj->message = "password is too short";
         $step3Obj->statusCode = $ERROR;
     }else if(strlen($_POST['password']) > 12){
         $step3Obj->message = "password is too long";
         $step3Obj->statusCode = $ERROR;
     }else{
         $db = new \database\Database();
         $query  = "UPDATE `user` SET `password`= :password WHERE  `email`= :email;";
         $db->query($query);
         $db->bind("password", $_POST['password']);
         $db->bind("email", $_SESSION['verifiedForgotPasswordEmail']);
         if($db->execute()){
             unset($_SESSION['verifiedForgotPasswordEmail']);
             unset($_SESSION['forgotPasswordEmail']);
             $step3Obj->message = "password is Updated Successfully";
             $step3Obj->statusCode = $SUCCESS;
         }else{
             $step3Obj->message = "something went wrong";
             $step3Obj->statusCode = $ERROR;
         }
     }
     return  $step3Obj;
}
if(isset($_POST['step'])){
    if($_POST['step'] === "1"){
       $obj =  step1();
    }else if($_POST['step'] === "2"){
        $obj =  step2();
    }else if($_POST['step'] === "3"){
        $obj = step3();
    }
}else{
    $obj->message = "invalid request";
    $obj->statusCode = $ERROR;
}

echo  json_encode($obj);



