<?php
$obj = new stdClass();
$obj->message = "done";
$obj->statusCode = 1;
$obj->body = "";

ob_start(); // Start output buffering

?>

<h1>Products</h1>
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

<!--                    table-->
<div class="row p-2 mt-3">
    <!--                        table head-->
    <div class="col-12 text-center bg-dark text-light fw-bold rounded  ">
        <div class="row">
            <div class="col-1 border-end d-flex justify-content-center align-items-center ">
                <span>ID</span></div>
            <div class="col-2  d-flex justify-content-center align-items-center ">Product Name</div>
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
            <div class="col-2 d-flex justify-content-center align-items-center ">Actions</div>
        </div>
    </div>
    <!--                        table body-->
    <?php
    require_once "../database/database.php";
    $db = new database\Database();
    $query = "SELECT * FROM product";
    $db->query($query);
    $products = $db->resultSet();


    foreach ($products as $product) {

        ?>

        <div class="col-12 text-center bg-white mt-2 border-bottom  fw-bold rounded  ">
            <div class="row">
                <div class="col-1 border-end d-flex justify-content-center align-items-center ">
                    <span><?php echo($product['product_id']); ?></span></div>
                <div class="col-2  d-flex justify-content-center align-items-center "><?php echo($product['product_name']); ?></div>
                <div class="col-7  border-start border-end">
                    <?php
                    $stockDB = new \database\Database();
                    $stockQuery = "SELECT * FROM stock
                                                    INNER JOIN color 
                                                    ON color.color_id = stock.color_color_id
                                                    INNER JOIN size
                                                    ON size.size_iid = stock.size_size_iid
                                                    WHERE stock.product_product_id = :pid";
                    $stockDB->query($stockQuery);
                    $stockDB->bind(":pid", $product['product_id']);
                    $stocks = $stockDB->resultSet();

                    foreach ($stocks as $stock) {
                        ?>

                        <div class="row border-bottom pb-1">
                            <div class="col-2  ">#<?php echo $stock['stock_id'] ?></div>
                            <div class="col-2">
                                <?php echo $stock['color_name'] ?>
                                (<?php echo $stock['color_hex'] ?>)
                                <div class="row"
                                     style="height: 10px; background-color:<?php echo $stock['color_hex'] ?> "></div>

                            </div>
                            <div class="col-2"><?php echo $stock['size'] ?></div>
                            <div class="col-2"><?php echo $stock['qty'] ?></div>
                            <div class="col-2">$<?php echo $stock['shipping_cost'] ?></div>
                            <div class="col-2">$<?php echo $stock['stock_price'] ?></div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
                <div class="col-2 d-flex flex-column justify-content-center  ">
                    <div class="row m-1">
                        <div class="btn btn-dark">
                            Update
                        </div>
                    </div>
                    <div class="row m-1">
                        <div id="productActions_<?php echo $product['product_id'] ?>"
                             onclick="activateDeactivateProduct( '<?php echo $product['product_id'] ?>',<?php echo $product['is_active'] == '1' ? 0 : 1 ?>)"
                             class="btn <?php echo $product['is_active'] == '1' ? 'btn-danger' : 'btn-primary' ?>">

                            <?php echo $product['is_active'] == '1' ? 'Deactivate' : 'Activate' ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php
    }
    ?>
</div>

<?php
// Get the contents of the output buffer and assign it to the body property of the object
$obj->body = ob_get_clean();

// Encode the object as JSON and output it
echo json_encode($obj); ?>



