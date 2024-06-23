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

function getOrderLeastStatus($orderID){
    $db = new \database\Database();
    $query = "SELECT * FROM order_status WHERE order_status.order_order_id = :orderID ORDER BY date_time DESC";
    $db->query($query);
    $db->bind(":orderID", $orderID);
    $result = $db->resultSet();
    $leastStatus = $result[0]['status'];
    return $leastStatus;
}
if (isUser()) {
    ob_start();
    ?>
    <h1>Completed Orders</h1>
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
        <div class="row">
            <div class="col-1 border-end d-flex justify-content-center align-items-center ">
                <span>Order ID</span></div>
            <div class="col-2  d-flex justify-content-center align-items-center ">Details</div>
            <div class="col-7  border-start border-end">
                <div class="row">
                    <div class="col-12 border-bottom border-1 border-light">Stocks</div>
                </div>
                <div class="row">
                    <div class="col-2  ">Stock ID</div>
                    <div class="col-2">Color</div>
                    <div class="col-2">Size</div>
                    <div class="col-2">Quantity</div>
                    <div class="col-2">Shipping cost</div>
                    <div class="col-2">price</div>
                </div>
            </div>
            <div class="col-2 d-flex justify-content-center align-items-center ">Status</div>
        </div>
    </div>
    <!--                        table body-->
    <?php
    $db = new database\Database();
    $query = "SELECT *
FROM `order` o
INNER JOIN (
    SELECT os.order_order_id, os.status, os.date_time
    FROM order_status os
    INNER JOIN (
        SELECT order_order_id, MAX(date_time) AS max_date_time
        FROM order_status
        GROUP BY order_order_id
    ) latest_status ON os.order_order_id = latest_status.order_order_id
                   AND os.date_time = latest_status.max_date_time
    WHERE os.status = 'PLACE_ORDER'
) os ON o.order_id = os.order_order_id

WHERE o.user_email = :email ";
    $db->query($query);
    $db->bind(":email", $_SESSION['user_email']);
    $orders = $db->resultSet();

    if(count($orders) == 0){
        echo  "<div class ='col-12 text-center text-danger'> no active order found'</div>";
    }

    foreach ($orders as $order) {
        $orderID = $order['order_id'];
        $details = "email : " . $order['user_email'] . "</br>";
        $details .= "address : " . $order['shipping_address'] . "</br>";
        $details .= "postalCode : " . $order['postal_code'] . "</br>";

        ?>

        <div class="col-12 text-center bg-white mt-2 border-bottom  fw-bold rounded  ">
            <div class="row">
                <div class="col-1 border-end d-flex justify-content-center align-items-center ">
                    <span><?php echo($orderID); ?></span>
                </div>
                <div class="col-2 border-end d-flex justify-content-center align-items-center ">
                    <span><?php echo($details); ?></span>
                </div>
                <div class="col-7 border-start border-end">
                <?php
                $db = new \database\Database();
                $query = "SELECT * FROM order_has_stock   INNER JOIN stock ON order_has_stock.stock_stock_id = stock.stock_id INNER JOIN  color ON color.color_id = stock.color_color_id INNER JOIN size on size.size_iid = stock.size_size_iid WHERE order_has_stock.order_order_id = :orderID";
                $db->query($query);
                $db->bind(":orderID", $orderID);
                $stocks = $db->resultSet();
                $leastOrderStatus = getOrderLeastStatus($orderID);
                foreach ($stocks as $stock) {

                    ?>
                    <div class="row border-bottom pb-1">
                        <div class="col-2  ">
                            <span><?php echo($stock['stock_id']); ?></span>
                        </div>
                        <div class="col-2">
                            <?php echo $stock['color_name'] ?>
                            (<?php echo $stock['color_hex'] ?>)
                            <div class="row"
                                 style="height: 10px; background-color:<?php echo $stock['color_hex'] ?> "></div>

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

                <div class="col-2 d-flex flex-column justify-content-center  ">
                    <div class="row m-1">
                        <div class="<?php echo  $leastOrderStatus == $PAYMENT_PROCESSING? 'text-danger':'text-primary'?>">
                             <?php echo  $leastOrderStatus?>



                    </div>
                    <div class="row m-1">
                        <button type="button" onclick="loadOrderProcessModelData('<?php echo $orderID?>')" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#myModal">View
                            Process
                        </button>
<!--                        <div id="orderActions_"-->
<!--                             onclick="activateDeactivateProduct( )"-->
<!--                             class="btn  btn-primary ">-->
<!---->
<!--                            'Activate' ?>-->
<!--                        </div>-->
                    </div>
                </div>

        </div>
        </div>

        </div>

        <!-- The Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderProcessModelID">Modal Title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <section class="py-5 ps-5">
                            <ul class="timeline-with-icons" id="processModelTimeline">
                            </ul>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }

    $obj->body .= ob_get_clean();

} else {
//    $obj -> message = "Access Denied";
//    $obj -> statusCode = $ERROR;
    $obj->body = "<div class='row d-flex justify-content-center align-items-center text-danger fw-bold fs-1' style='height: 100vh'> Authentication Failed  </div>";
}

echo json_encode($obj);