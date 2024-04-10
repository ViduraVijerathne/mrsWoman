<?php
function show404($message)
{
    echo  $message;
}

function showAuthFailure(){
    return "You are not authorized to access this page";
}