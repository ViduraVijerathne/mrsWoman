<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
require_once "../const/auth.php";

$response = new stdClass();

if(isUser()){

    if (isset($_SESSION['user_email']) && isset($_POST['address_id'])) {
        $userEmail = $_SESSION['user_email'];
        $addressID = $_POST['address_id'];

        $db = new \database\Database();
        $query = "DELETE FROM address WHERE address_id = :addressID AND user_email = :userEmail";
        $db->query($query);
        $db->bind(":addressID", $addressID);
        $db->bind(":userEmail", $userEmail);

        if ($db->execute()) {
            $response->status = $SUCCESS;
            $response->message = "Address deleted successfully";
        } else {
            $response->status = $ERROR;
            $response->message = "Failed to delete address";
        }
    } else {
        $response->status = $ERROR;
        $response->message = "Invalid request";
    }
}else{
    $response->status = $ERROR;
    $response->message = "Authentication Failed";
}


echo json_encode($response);