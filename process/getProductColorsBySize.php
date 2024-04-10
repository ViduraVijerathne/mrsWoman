<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";

$obj = new stdClass();
if (!isset($_GET["pid"])) {
//    length validation max 100
    $obj->message = "product ID is missing";
    $obj->statusCode = $ERROR;
} else if (!isset($_GET["sizeID"])) {
    $obj->message = "size ID is missing";
    $obj->statusCode = $ERROR;
}else{
    $db = new \database\Database();
    $q = "SELECT * FROM product INNER JOIN stock ON product.product_id = stock.product_product_id INNER JOIN size ON size.size_iid = stock.size_size_iid INNER JOIN color ON color.color_id = stock.color_color_id  WHERE product.product_id = :pid AND size_size_iid = :sizeID ";

    $db->query($q);
    $db->bind(":sizeID",$_GET["sizeID"]);
    $db->bind(":pid",$_GET["pid"]);
    $results  = $db->resultSet();
    $stocks = array();
    foreach ($results as $result){
        $stock = new stdClass();
        $stock->productID = $result['product_id'];
        $stock->productName = $result['product_name'];
        $stock->productDescription = $result['product_description'];
        $stock->colorID = $result['color_id'];
        $stock->colorName = $result['color_name'];
        $stock->colorHex = $result['color_hex'];
        $stock->sizeID = $result['size_iid'];
        $stock->sizeName = $result['size'];
        $stock->price = $result['stock_price'];
        $stock->shipping=$result['shipping_cost'];
        $stock->qty = $result['qty'];

        array_push($stocks, $stock);

    }
    $obj->stocks = $stocks;
    $obj->message = "Success";
    $obj->statusCode = $SUCCESS;
}








echo  json_encode($obj);
?>
