<?php
require_once '../const/statesCodes.php';
require_once '../const/auth.php';
require_once "../database/database.php";
require_once "../const/orderStatus.php";
require_once "../components/error404.php";
global $SUCCESS;
global $ERROR;
$obj = new stdClass();
$obj->message = "done";
$obj->statusCode = $ERROR;

if (isAdmin()) {
    $db = new \database\Database();
    $q = "SELECT 
    DATE_FORMAT(order_status.date_time, '%Y-%m') AS month,
    SUM(order_has_stock.order_qty * stock.stock_price) AS total_sales
FROM 
    order_has_stock
INNER JOIN 
    stock ON stock.stock_id = order_has_stock.stock_stock_id
INNER JOIN 
    `order` ON `order`.order_id = order_has_stock.order_order_id
INNER JOIN 
    order_status ON order_status.order_order_id = `order`.order_id
WHERE 
    order_status.`status` = 'PLACE_ORDER'
GROUP BY 
    DATE_FORMAT(order_status.date_time, '%Y-%m')
ORDER BY 
    DATE_FORMAT(order_status.date_time, '%Y-%m') ASC;
";

    // Get the current date and calculate the start of the last year
    $currentDate = new DateTime();
    $startDate = (clone $currentDate)->modify('-11 months')->modify('first day of this month');


    $db->query($q);
    $results = $db->resultSet();
    // Initialize resData array with all months of the last year set to 0
    $resData = [];
    for ($i = 0; $i < 12; $i++) {
        $month = $startDate->format('Y M');
        $resData[$month] = 0;
        $startDate->modify('+1 month');
    }

    // Populate resData with actual sales data
    foreach ($results as $row) {
        $month = DateTime::createFromFormat('Y-m', $row['month'])->format('Y M');
        $resData[$month] = (float)$row['total_sales'];
    }

    $obj->statusCode = $SUCCESS;
    $obj->body = $resData;
}
else {
    $obj->message = "authentication failed";
    $obj->statusCode = $ERROR;
}


echo json_encode($obj);
?>