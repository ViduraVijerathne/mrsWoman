<?php
global $ERROR;
require_once '../const/statesCodes.php';
require_once '../const/auth.php';
require_once "../database/database.php";
require_once "../const/orderStatus.php";
global $ORDERING;


$obj = new stdClass();
$obj->message = "done";
$obj->statusCode = 1;
$obj->body = "";

function getOrderLeastStatus($orderID) {
    $db = new \database\Database();
    $query = "SELECT * FROM order_status WHERE order_status.order_order_id = :orderID ORDER BY date_time DESC";
    $db->query($query);
    $db->bind("orderID", $orderID);
    $result = $db->resultSet();
    $leastStatus = $result[0]['status'];
    return $leastStatus;
}

if (isAdmin()) {
    $orderID = isset($_POST['orderID']) ? $_POST['orderID'] : '';
    $productID = isset($_POST['productID']) ? $_POST['productID'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $db = new database\Database();
    $query = "SELECT * FROM order_status INNER JOIN `order` ON `order`.order_id = order_status.order_order_id WHERE order_status.`status` = 'PLACE_ORDER'";

    if (!empty($orderID)) {
        $query .= " AND `order`.order_id = :orderID";
    }
//    if (!empty($productID)) {
//        $query .= " AND `order`.product_id = :productID";
//    }
    if (!empty($email)) {
        $query .= " AND `order`.user_email = :email";
    }
    $db->query($query);

    if (!empty($orderID)) {
        $db->bind("orderID", $orderID);
    }
//    if (!empty($productID)) {
//        $db->bind("productID", $productID);
//    }
    if (!empty($email)) {
        $db->bind("email", $email);
    }

    $obj->query = $query;

    $orders = $db->resultSet();
    $obj -> resultCount = count($orders);

    if($obj -> resultCount > 0){
        foreach ($orders as $order) {
            $orderID = $order['order_id'];
            $details = "email : " . $order['user_email'] . "</br>";
            $details .= "address : " . $order['shipping_address'] . "</br>";
            $details .= "postalCode : " . $order['postal_code'] . "</br>";
            ?>
            <div class="col-12 text-center bg-white mt-2 border-bottom fw-bold rounded">
                <div class="row">
                    <div class="col-1 border-end d-flex justify-content-center align-items-center">
                        <span><?php echo($orderID); ?></span>
                    </div>
                    <div class="col-2 border-end d-flex justify-content-center align-items-center">
                        <span><?php echo($details); ?></span>
                    </div>
                    <div class="col-7 border-start border-end">
                        <?php
                        $db = new \database\Database();
                        $query = "SELECT * FROM order_has_stock INNER JOIN stock ON order_has_stock.stock_stock_id = stock.stock_id INNER JOIN color ON color.color_id = stock.color_color_id INNER JOIN size on size.size_iid = stock.size_size_iid WHERE order_has_stock.order_order_id = :orderID";
                        $db->query($query);
                        $db->bind("orderID", $orderID);
                        $stocks = $db->resultSet();
                        $leastOrderStatus = getOrderLeastStatus($orderID);
                        foreach ($stocks as $stock) {
                            ?>
                            <div class="row border-bottom pb-1">
                                <div class="col-2">
                                    <span><?php echo($stock['stock_id']); ?></span>
                                </div>
                                <div class="col-2">
                                    <?php echo $stock['color_name'] ?> (<?php echo $stock['color_hex'] ?>)
                                    <div class="row" style="height: 10px; background-color:<?php echo $stock['color_hex'] ?>;"></div>
                                </div>
                                <div class="col-2"><?php echo $stock['size'] ?></div>
                                <div class="col-2"><?php echo $stock['order_qty'] ?></div>
                                <div class="col-2">$<?php echo $stock['shipping_cost'] ?></div>
                                <div class="col-2">$<?php echo $stock['stock_price'] ?></div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-2 d-flex flex-column justify-content-center">
                        <div class="row m-1">
                            <button type="button" onclick="loadOrderProcessModelData('<?php echo $orderID ?>')" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#myModal">View Process</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        $obj->body .= ob_get_clean();
    }

} else {
    $obj->message = "Authentication Failed";
    $obj->statusCode = $ERROR;
    $obj->body = "<div class='row d-flex justify-content-center align-items-center text-danger fw-bold fs-1' style='height: 100vh'> Authentication Failed </div>";
}

echo json_encode($obj);
?>
