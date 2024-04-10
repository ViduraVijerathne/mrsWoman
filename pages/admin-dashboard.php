<?php
require_once "../const/statesCodes.php";
require_once "../const/app.php";
global $SUCCESS;
global $IS_DEBUG_MODE;

$obj = new stdClass();
$obj -> message = "done";
$obj -> statusCode = $SUCCESS;
$obj -> body = "admin panel";
if($IS_DEBUG_MODE){
    sleep(2);
}
echo json_encode($obj);

?>