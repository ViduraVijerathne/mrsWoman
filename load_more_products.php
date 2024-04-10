<?php
require_once "database/Database.php";
require_once "components/productItem.php";
if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
    $db = new \database\Database();
    $query = "SELECT * FROM product LIMIT $limit";
    $db->query($query);
    $results = $db->resultSet();

    foreach ($results as $row){
        productItemComponent($row);
    }
}
