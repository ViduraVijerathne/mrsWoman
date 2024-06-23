<?php
global $ERROR,$PAYMENT_PROCESSING,$PAYMENT_DONE;
require_once '../const/statesCodes.php';
require_once '../const/auth.php';
require_once "../database/database.php";
require_once "../const/orderStatus.php";
global $ORDERING;

$obj = new stdClass();
$obj->message = "done";
$obj->statusCode = 1;
$obj->body = "";

if (isUser()) {
    ob_start();
    ?>
    <h1>Address Book</h1>
    <div class="row ">
        <div class="col-2">
            <input class="form-control" type="text" placeholder="country" id="addAddress_country">
        </div>
        <div class="col-2">
            <input class="form-control" type="text" placeholder="province" id="addAddress_province">
        </div>
        <div class="col-2">
            <input class="form-control" type="text" placeholder="district" id="addAddress_district">
        </div>
        <div class="col-2">
            <input class="form-control" type="text" placeholder="city" id="addAddress_city">
        </div>
        <div class="col-2">
            <input class="form-control" type="text" placeholder="postal code" id="addAddress_postalcode">
        </div>
        <div class="col-2">
            <input class="form-control" type="text" placeholder="address" id="addAddress_address">
        </div>
        <div class="col-2 mt-1">
            <div class="btn btn-outline-dark" onclick="addAddress()">
               ADD
            </div>
        </div>
    </div>

    <!-- Address Table -->
    <div class="row p-2 mt-3">
        <!-- Table Head -->
        <div class="col-12 text-center bg-dark text-light fw-bold rounded">
            <div class="row">
                <div class="col-1 border-end d-flex justify-content-center align-items-center">
                    <span>Address ID</span>
                </div>
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <span>Country</span>
                </div>
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <span>Province</span>
                </div>
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <span>District</span>
                </div>
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <span>City</span>
                </div>
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <span>Postal Code</span>
                </div>
                <div class="col-1 d-flex justify-content-center align-items-center">
                    <span>Actions</span>
                </div>
            </div>
        </div>
        <!-- Table Body -->
        <?php
        $db = new \database\Database();
        $query = "SELECT * FROM address WHERE user_email = :email";
        $db->query($query);
        $db->bind(":email", $_SESSION['user_email']);
        $addresses = $db->resultSet();

        if (count($addresses) == 0) {
            echo "<div class='col-12 text-center text-danger'>No addresses found</div>";
        } else {
            foreach ($addresses as $address) {
                $addressID = $address['address_id'];
                $country = $address['country'];
                $province = $address['province'];
                $district = $address['district'];
                $city = $address['city'];
                $postalcode = $address['postalcode'];
                $addressDetails = $address['address'];
                ?>
                <div class="col-12 text-center bg-white mt-2 border-bottom fw-bold rounded">
                    <div class="row">
                        <div class="col-1 border-end d-flex justify-content-center align-items-center">
                            <span><?php echo $addressID; ?></span>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <span><?php echo htmlspecialchars($country); ?></span>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <span><?php echo htmlspecialchars($province); ?></span>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <span><?php echo htmlspecialchars($district); ?></span>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <span><?php echo htmlspecialchars($city); ?></span>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <span><?php echo htmlspecialchars($postalcode); ?></span>
                        </div>
                        <div class="col-1 d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-danger" onclick="deleteAddress('<?php echo $addressID; ?>')">DELETE</button>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
        <?php

    $obj->body .= ob_get_clean();

} else {
//    $obj -> message = "Access Denied";
//    $obj -> statusCode = $ERROR;
    $obj->body = "<div class='row d-flex justify-content-center align-items-center text-danger fw-bold fs-1' style='height: 100vh'> Authentication Failed  </div>";
}

echo json_encode($obj);