<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
$obj = new stdClass();
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
    $q = "SELECT * FROM user WHERE email = :email AND password = :password";
    $db->query($q);
    $db->bind(':email', $email);
    $db->bind(':password', $password);
    $results  = $db->resultSet();


    if(count($results) > 0){
        $user = $results[0];
        if($user['is_verified'] == 0){
            $obj->message = "Your account is not verified";
            $obj->statusCode = $ERROR;
            sendVC($email);


        }else{
            session_start();
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_password'] = $user['password'];
            $_SESSION['user_mobile'] = $user['mobile'];
            $_SESSION['user_name'] = $user['name'];

            if($rememberMe == "true"){
                setcookie("user_email", $user['email'], time() + (86400 * 30), "/");
                setcookie("user_password", $user['password'], time() + (86400 * 30), "/");
            }
            $obj->message = 'success!';
            $obj->statusCode = $SUCCESS;
        }




    }else{
        $obj->message = "email or password is incorrect";
        $obj->statusCode = $ERROR;
    }

}


echo  json_encode($obj);
