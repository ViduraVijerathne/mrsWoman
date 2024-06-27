<?php

function isAdmin(){
    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION['admin_email']) && $_SESSION['admin_password']){
        return true;
    }else{
        return  false;
    }
}

function isUser(){
    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION['user_email']) && $_SESSION['user_password'] && $_SESSION['is_verified']){

        return ($_SESSION['is_verified'] == 1);
    }else{
        return  false;
    }
}
