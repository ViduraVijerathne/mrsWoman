<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
require_once "../const/auth.php";
$obj = new stdClass();
if(isUser()){
    $user_email = $_SESSION['user_email'];

    // Check if all required POST variables are set
    if (isset($_POST["country"], $_POST["province"], $_POST["district"], $_POST["city"], $_POST["postalcode"], $_POST["address"])) {
        // Sanitize and validate the input
        $country = filter_var(trim($_POST["country"]), FILTER_SANITIZE_STRING);
        $province = filter_var(trim($_POST["province"]), FILTER_SANITIZE_STRING);
        $district = filter_var(trim($_POST["district"]), FILTER_SANITIZE_STRING);
        $city = filter_var(trim($_POST["city"]), FILTER_SANITIZE_STRING);
        $postalcode = filter_var(trim($_POST["postalcode"]), FILTER_SANITIZE_STRING);
        $address = filter_var(trim($_POST["address"]), FILTER_SANITIZE_STRING);

        // Check if any field is empty
        if (empty($country) || empty($province) || empty($district) || empty($city) || empty($postalcode) || empty($address)) {
            $obj->message = "All fields are required.";
            $obj->statusCode = $ERROR;
            echo json_encode($obj);
            exit;
        }

        // Validate postal code format (example for US ZIP codes)
        if (!preg_match('/^[0-9]{5}(?:-[0-9]{4})?$/', $postalcode)) {
            $obj->message = "Invalid postal code format.";
            $obj->statusCode = $ERROR;
            echo json_encode($obj);
            exit;
        }

        $db = new \database\Database();
        $q = "INSERT INTO address (country, province, district, city, postalcode, address, user_email) 
VALUES (:country,:province,:district,:city,:postalCode,:address,:email)";
        $db->query($q);
        $db->bind("country",$country);
        $db->bind("province", $province);
        $db->bind("district", $district);
        $db->bind("city", $city);
        $db->bind("postalCode", $postalcode);
        $db->bind("address", $address);
        $db->bind("email", $user_email);

        if ($db->execute()) {
            $obj->message = "Address added successfully.";
            $obj->statusCode = $SUCCESS;
        } else {
            $obj->message = "Failed to add address.";
            $obj->statusCode = $ERROR;
        }
    }else {
        $obj->message = "Missing required fields.";
        $obj->statusCode = $ERROR;
    }
}else{
    $obj->message = "authentication failed";
    $obj->statusCode = $ERROR;
}




echo json_encode($obj);