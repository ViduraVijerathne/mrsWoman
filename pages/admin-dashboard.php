<?php

use database\Database;

require_once "../const/statesCodes.php";
require_once "../const/app.php";
require_once '../const/auth.php';
require_once "../database/Database.php";
global $SUCCESS;
global $IS_DEBUG_MODE;

$obj = new stdClass();
$obj->message = "done";
$obj->statusCode = $SUCCESS;

if ($IS_DEBUG_MODE) {
//    sleep(2);
}
$obj->body = "";
if (isAdmin()) {

    ob_start();
    ?>

    <div class="row mt-5">
        <div class="col-12">
            <p class="h3 fw-bold">Dashboard</p>
        </div>
        <div class="col-12 p-3">
            <div class="row  bg-white border rounded-4">
                <canvas id="myLineChart" width="400" height="200" onload="loadDashboardChart()"></canvas>

            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-12 col-lg-4 p-3">
                    <div class="row bg-dark-subtle rounded-4" >
                        <div class="col-3 d-flex justify-content-center align-items-center " style="height: 100px;">
                            <div class="bg-dark rounded-circle d-flex justify-content-center align-items-center " style="height: 50px; width: 50px">
                                <i class="bi bi-box-seam-fill text-light"></i>
                            </div>
                        </div>
                        <div class="col-9 d-flex flex-column justify-content-center fw-bold fs-3 " style="height: 100px;">
                            <div class="row">
                                Total Products
                            </div>
                            <div class="row">
                               <?php
                               $productCountDB = new \database\Database();
                               $q= "SELECT COUNT(product.product_id) AS total FROM product";
                               $productCountDB->query($q);
                               $result = $productCountDB->resultSet();
                               echo $result[0]["total"];
                               ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 p-3">
                    <div class="row bg-dark-subtle rounded-4" >
                        <div class="col-3 d-flex justify-content-center align-items-center " style="height: 100px;">
                            <div class="bg-dark rounded-circle d-flex justify-content-center align-items-center " style="height: 50px; width: 50px">
                                <i class="bi bi-coin text-light"></i>
                            </div>
                        </div>
                        <div class="col-9 d-flex flex-column justify-content-center fw-bold fs-3 " style="height: 100px;">
                            <div class="row">
                                Total Sales
                            </div>
                            <div class="row">
                                $ <?php
                                $productCountDB = new \database\Database();
                                $q= "SELECT SUM(order_has_stock.order_qty * stock.stock_price) AS total_sales
FROM 
    order_has_stock
INNER JOIN 
    stock ON stock.stock_id = order_has_stock.stock_stock_id
INNER JOIN 
    `order` ON `order`.order_id = order_has_stock.order_order_id
INNER JOIN 
    order_status ON order_status.order_order_id = `order`.order_id
WHERE 
    order_status.`status` = 'PLACE_ORDER'";
                                $productCountDB->query($q);
                                $result = $productCountDB->resultSet();
                                echo $result[0]["total_sales"];
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 p-3">
                    <div class="row bg-dark-subtle rounded-4" >
                        <div class="col-3 d-flex justify-content-center align-items-center " style="height: 100px;">
                            <div class="bg-dark rounded-circle d-flex justify-content-center align-items-center " style="height: 50px; width: 50px">
                                <i class="bi bi-coin text-light"></i>
                            </div>
                        </div>
                        <div class="col-9 d-flex flex-column justify-content-center fw-bold fs-3 " style="height: 100px;">
                            <div class="row">
                               Today Total Sales
                            </div>
                            <div class="row">
                                 <?php
                                $productCountDB = new \database\Database();
                                $q= "SELECT 
    SUM(ohs.order_qty) AS total_quantity_sold,
    SUM(ohs.order_qty * s.stock_price) AS total_sales_amount
FROM 
    `order` o
INNER JOIN 
    order_has_stock ohs ON o.order_id = ohs.order_order_id
INNER JOIN 
    order_status os ON os.order_order_id = o.order_id
INNER JOIN 
    stock s ON s.stock_id = ohs.stock_stock_id
WHERE 
    os.`status` = 'PLACE_ORDER' AND 
    DATE(os.date_time) = CURDATE();
";
                                $productCountDB->query($q);
                                $result = $productCountDB->resultSet();
                                echo $result[0]["total_quantity_sold"];
                                echo  " Items Sold </br>";
                                echo "$";
                                echo  $result[0]["total_sales_amount"];
                                echo " Sales"
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 p-3">
            <div class="row ">
                <div class="col-12 col-lg-5 bg-white border rounded-3 p-2 offset-1 " >
                    <div class=" m-3 fw-bold text-center fs-3">Low Stocks Products</div>

                    <div class="row">
                        <div class="col-12 overflow-y-scroll" style="height: 500px;">
                            <?php
                            $lowStockDB = new \database\Database();
                            $q = "SELECT * FROM stock 
                            INNER JOIN product ON product.product_id = stock.product_product_id
                            INNER JOIN color ON color.color_id = stock.color_color_id
                            INNER JOIN size ON size.size_iid = stock.size_size_iid
                            WHERE stock.qty < 10";
                            $lowStockDB->query($q);
                            $result = $lowStockDB->resultSet();
                            for($lowStockI = 0 ; $lowStockI < count($result); $lowStockI++){
                                $lowStockRow = $result[$lowStockI];
                                ?>
                                <div class="row mt-3 ms-1 me-1 bg-danger-subtle rounded-3 pb-1 ">
                                    <div class="col-12 fw-bold"><?php echo $lowStockRow['product_name']?></div>
                                    <div class="col-4"><?php echo  $lowStockRow['qty']?> Items</div>
                                    <div class="col-4">COLOR <div class="btn btn-outline-dark"><?php echo  $lowStockRow['color_name']?></div></div>
                                    <div class="col-4">COLOR <div class="btn btn-outline-dark"><?php echo  $lowStockRow['size']?></div></div>
                                    <div class="col-3 me-3 ms-3 mt-3 ">
                                        <input type="number" id="addStockField_<?php echo $lowStockRow['stock_id']?>" class="form-control" placeholder="ADD stock">
                                    </div>
                                    <div class="btn btn-dark me-3 ms-3 mt-3 col-3 " onclick="addQuantityToStock('<?php echo $lowStockRow['stock_id']?>',0)"> ADD Stock</div>
                                </div>
                                <?php

                            }
                            ?>
                        </div>
                    </div>


                </div>
                <div class="col-12 col-lg-5 bg-white border rounded-3 p-2 offset-1 " >
                    <div class=" m-3 fw-bold text-center fs-3"> Trending Products In Month</div>

                    <div class="row">
                        <div class="col-12 overflow-y-scroll" style="height: 500px;">
                            <?php
                            $lowStockDB = new \database\Database();
                            $q = "SELECT 
    p.product_name,
    SUM(ohs.order_qty) AS total_quantity_sold
FROM 
    `order` o
INNER JOIN 
    order_has_stock ohs ON o.order_id = ohs.order_order_id
INNER JOIN 
    order_status os ON os.order_order_id = o.order_id
INNER JOIN 
    stock s ON s.stock_id = ohs.stock_stock_id
INNER JOIN 
    product p ON p.product_id = s.product_product_id
WHERE 
    os.`status` = 'PLACE_ORDER' AND 
    MONTH(os.date_time) = MONTH(CURDATE()) AND 
    YEAR(os.date_time) = YEAR(CURDATE())
GROUP BY 
    p.product_name
ORDER BY 
    total_quantity_sold DESC
LIMIT 5;
";
                            $lowStockDB->query($q);
                            $result = $lowStockDB->resultSet();
                            for($lowStockI = 0 ; $lowStockI < count($result); $lowStockI++){
                                $lowStockRow = $result[$lowStockI];
                                ?>
                                <div class="row mt-3 ms-1 me-1 bg-success-subtle rounded-3 pb-1 ">
                                    <div class="col-9 fw-bold"><?php echo $lowStockRow['product_name']?></div>
                                    <div class="col-3 btn btn-success"><?php echo  $lowStockRow['total_quantity_sold']?> Items sold</div>

                                </div>
                                <?php

                            }
                            ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    <?php
    $obj->body = ob_get_clean();
} else {
    $obj->body = showAuthFailure();
}


echo json_encode($obj);

?>