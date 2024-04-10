<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
$obj = new stdClass();


if(!isset($_POST['email'])){
    $obj->message = "email is missing";
    $obj->statusCode = $ERROR;
}else if(!isset($_POST['password'])){
    $obj->message = "password is missing";
    $obj->statusCode = $ERROR;
}else if(!isset($_POST['rememberMe'])){
    $obj->message = "rememberMe is missing";
    $obj->statusCode = $ERROR;
}else{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberMe = $_POST['rememberMe'];
    $db = new \database\Database();
    $q = "SELECT * FROM admin WHERE email = :email AND password = :password";
    $db->query($q);
    $db->bind(':email', $email);
    $db->bind(':password', $password);
    $results  = $db->resultSet();


    if(count($results) > 0){
        $user = $results[0];

            session_start();
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['admin_password'] = $user['password'];
            $_SESSION['admin_mobile'] = $user['mobile'];
            $_SESSION['admin_name'] = $user['name'];

            if($rememberMe == "true"){
                setcookie("admin_email", $user['email'], time() + (86400 * 30), "/");
                setcookie("admin_password", $user['password'], time() + (86400 * 30), "/");
            }
            $obj->message = 'success!';
            $obj->statusCode = $SUCCESS;





    }else{
        $obj->message = "email or password is incorrect";
        $obj->statusCode = $ERROR;
    }

}


echo  json_encode($obj);
