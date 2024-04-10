<?php
global $ERROR, $PAYMENT_PROCESSING, $PAYMENT_DONE;
require_once '../const/statesCodes.php';
require_once '../const/auth.php';
require_once "../database/database.php";
require_once "../const/orderStatus.php";
global $ORDERING;
session_start();
$obj = new stdClass();
$obj->message = "done";
$obj->statusCode = 1;
$obj->body = "";
if (isAdmin()) {

    ob_start();
    ?>
    <h1>Customers</h1>
    <div class="row ">
        <div class="col-6 offset-3">
            <input class="form-control" type="text">
        </div>
        <div class="col-3">
            <div class="btn btn-dark">
                <i class="bi bi-search"></i>
            </div>
        </div>
    </div>

    <!--    table-->
    <div class="row p-2 mt-3">

    <!--                        table head-->
    <div class="col-12 text-center bg-dark text-light fw-bold rounded  ">
        <div class="row mb-3">
            <div class="col-2 d-flex justify-content-center align-items-center ">Email</div>
            <div class="col-2  d-flex justify-content-center align-items-center ">Name</div>
            <div class="col-2  d-flex justify-content-center align-items-center ">Mobile</div>
            <div class="col-2  d-flex justify-content-center align-items-center ">Address</div>
            <div class="col-2  d-flex justify-content-center align-items-center ">&nsup;</div>
            <div class="col-2 d-flex justify-content-center align-items-center ">Actions</div>
        </div>
    </div>
    <?php
    $db = new database\Database();
    $query = "SELECT * FROM user";
    $db->query($query);
    $users = $db->resultSet();
    foreach ($users as $user) {
        $email = $user['email'];
        $name = $user['name'];
        $mobile = $user['mobile'];
        $address = "not set";
        $isVerified = $user['is_verified'];
        ?>
        <div class="col-12 text-center bg-white mb-1  fw-bold rounded  ">
            <div class="row">
                <div class="col-2 d-flex justify-content-center align-items-center "><?php echo  $email?> </div>
                <div class="col-2  d-flex justify-content-center align-items-center "><?php echo  $name?></div>
                <div class="col-2  d-flex justify-content-center align-items-center "><?php echo  $mobile?></div>
                <div class="col-2  d-flex justify-content-center align-items-center "><?php echo  $address?></div>
                <div class="col-2  d-flex justify-content-center align-items-center <?php echo  $isVerified==0 ? "text-danger" : "text-success"?> "><?php echo  $isVerified==0 ? "none-verified" : "verified"?></div>
                <div class="col-2 d-flex justify-content-center align-items-center p-1 ">
                    <button class="btn <?php echo  $isVerified==1 ? "btn-danger" : "btn-success"?> "><?php echo  $isVerified==0 ? "add verification " : "remove verification"?> </button>
                </div>
            </div>
        </div>


        <?php
    }


    ?>


    <?php

    $obj->body .= ob_get_clean();
} else {
    $obj->body = "<div class='row d-flex justify-content-center align-items-center text-danger fw-bold fs-1' style='height: 100vh'> Authentication Failed  </div>";

}

echo json_encode($obj);
?>