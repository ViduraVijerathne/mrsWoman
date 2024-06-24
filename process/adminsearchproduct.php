<?php

require_once "../const/statesCodes.php";
require_once "../database/Database.php";

$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : "";
$category = isset($_POST['category']) ? intval($_POST['category']) : 0;
$size = isset($_POST['size']) ? intval($_POST['size']) : 0;
$priceFrom = isset($_POST['priceFrom']) ? floatval($_POST['priceFrom']) : 0;
$priceTo = isset($_POST['priceTo']) ? floatval($_POST['priceTo']) : 0;

$db = new \database\Database();

$query = "SELECT p.product_id, p.product_name, p.is_active 
          FROM product p 
          LEFT JOIN stock s ON p.product_id = s.product_product_id
          LEFT JOIN size sz ON sz.size_iid = s.size_size_iid
          WHERE 1=1";

$params = [];

if (!empty($keyword)) {
    $query .= " AND p.product_name LIKE :keyword";
    $params[':keyword'] = "%$keyword%";
}

if ($category > 0) {
    $query .= " AND p.category_id = :category";
    $params[':category'] = $category;
}

if ($size > 0) {
    $query .= " AND sz.size_iid = :size";
    $params[':size'] = $size;
}

if ($priceFrom > 0) {
    $query .= " AND s.stock_price >= :priceFrom";
    $params[':priceFrom'] = $priceFrom;
}

if ($priceTo > 0) {
    $query .= " AND s.stock_price <= :priceTo";
    $params[':priceTo'] = $priceTo;
}

$db->query($query);
foreach ($params as $key => $value) {
    $db->bind($key, $value);
}

$products = $db->resultSet();

$response = "";

foreach ($products as $product) {
    $response .= "
    <div class='col-12 text-center bg-white mt-2 border-bottom fw-bold rounded'>
        <div class='row'>
            <div class='col-1 border-end d-flex justify-content-center align-items-center'>
                <span>{$product['product_id']}</span>
            </div>
            <div class='col-2 d-flex justify-content-center align-items-center'>
                {$product['product_name']}
            </div>
            <div class='col-7 border-start border-end'>";

    $stockDB = new \database\Database();
    $stockQuery = "SELECT * FROM stock
                   INNER JOIN color ON color.color_id = stock.color_color_id
                   INNER JOIN size ON size.size_iid = stock.size_size_iid
                   WHERE stock.product_product_id = :pid";
    $stockDB->query($stockQuery);
    $stockDB->bind(":pid", $product['product_id']);
    $stocks = $stockDB->resultSet();

    foreach ($stocks as $stock) {
        $response .= "
        <div class='row border-bottom pb-1'>
            <div class='col-2'>#{$stock['stock_id']}</div>
            <div class='col-2'>
                {$stock['color_name']} ({$stock['color_hex']})
                <div class='row' style='height: 10px; background-color:{$stock['color_hex']}'></div>
            </div>
            <div class='col-2'>{$stock['size']}</div>
            <div class='col-2'>{$stock['qty']}</div>
            <div class='col-2'> {$stock['shipping_cost']}</div>
            <div class='col-2'> {$stock['stock_price']}</div>
        </div>";
    }

    $response .= "
            </div>
            <div class='col-2 d-flex flex-column justify-content-center'>
                <div class='row m-1'>
                    <div class='btn btn-dark' onclick='updateProduct({$product['product_id']})'>
                        Update
                    </div>
                </div>
                <div class='row m-1'>
                    <div id='productActions_{$product['product_id']}' 
                         onclick='activateDeactivateProduct({$product['product_id']}, " . ($product['is_active'] == '1' ? 0 : 1) . ")' 
                         class='btn " . ($product['is_active'] == '1' ? 'btn-danger' : 'btn-primary') . "'>
                        " . ($product['is_active'] == '1' ? 'Deactivate' : 'Activate') . "
                    </div>
                </div>
            </div>
        </div>
    </div>";
}

echo $response;

