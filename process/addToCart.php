<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
session_start();
$obj = new stdClass();

function getStockID($productID,$sizeID,$colorID,$qty){
    $db = new \database\Database();
    $q = "SELECT * FROM stock WHERE stock.product_product_id = :productID AND stock.size_size_iid = :sizeID AND stock.color_color_id  = :colorID";
    $db->query($q);
    $db->bind(":productID", $productID);
    $db->bind(":sizeID", $sizeID);
    $db->bind(":colorID", $colorID);
    $results  = $db->resultSet();
    $maxqty = 0;
    $stockID = 0;
    for($i = 0; $i <count($results); $i++) {
        $stock = $results[$i];
        if($stock['qty'] >= $qty ){
            $maxqty = $stock['qty'];
            $stockID = $stock['stock_id'];
        }
    }

    if($stockID == 0){
        return "NOSTOCK";
    }else{
        return $stockID;
    }


}
function checkAlreadyHaveInCart($stockID){
    $email= $_SESSION['user_email'];
    $db = new \database\Database();
    $q = "SELECT * FROM cart WHERE cart.user_email = :email AND cart.stock_stock_id = :stockID";
    $db->query($q);
    $db->bind(":email", $email);
    $db->bind(":stockID", $stockID);
    $results  = $db->resultSet();
    if(count($results) > 0){
        return true;
    }else{
        return false;
    }


}
function updateQtyInCart($stockID,$qty){
    $db = new \database\Database();
    $q = "UPDATE cart SET cart.cart_qty = :qty WHERE cart.stock_stock_id = :stockID AND  cart.user_email = :email";
    $db->query($q);
    $db->bind(":qty", $qty);
    $db->bind(":stockID", $stockID);
    $db->bind(":email", $_SESSION['user_email']);
    $db->execute();
}

function addToCart($stockID,$qty){
    $db = new \database\Database();
    $q = "INSERT INTO cart(user_email,stock_stock_id,cart_qty) VALUES (:email,:stockID,:qty)";
    $db->query($q);
    $db->bind(":email", $_SESSION['user_email']);
    $db->bind(":stockID", $stockID);
    $db->bind(":qty", $qty);
    $db->execute();
}
if(!isset($_SESSION['user_email'])){
    $obj -> message = "anouthenticated";
    $obj -> statusCode = $ERROR;
}else if(!isset($_POST['productID'])){
    $obj -> message = "productID missing";
    $obj -> statusCode = $ERROR;
}else if(!isset($_POST['colorID'])){
    $obj -> message = "color ID missing";
    $obj -> statusCode = $ERROR;
}else if(!isset($_POST['sizeID'])){
    $obj -> message = "sizeID missing";
    $obj -> statusCode = $ERROR;
}else if(!isset($_POST['qty'])){
    $obj -> message = "quentity is missing";
    $obj -> statusCode = $ERROR;
}else{
   $productID = $_POST['productID'];
   $colorID = $_POST['colorID'];
   $sizeID = $_POST['sizeID'];
   $qty = $_POST['qty'];
   $stockID = getStockID($productID,$sizeID,$colorID,$qty);
   if($stockID == "NOSTOCK"){
       $obj -> message = "no stock available";
       $obj -> statusCode = $ERROR;
   }else{
       if(checkAlreadyHaveInCart($stockID)){
           updateQtyInCart($stockID,$qty);
           $obj -> message = "Updated quantity cart";
       }else{
           addToCart($stockID,$qty);
           $obj -> message = "Added to cart";
       }
       $obj -> statusCode = $SUCCESS;
   }


}


echo  json_encode($obj);

