<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
require_once '../const/orderStatus.php';

session_start();
$obj = new stdClass();
function getStock($stockID){
    $db = new \database\Database();
    $query = "SELECT * FROM stock 
                INNER JOIN product ON product.product_id = stock.product_product_id
                INNER JOIN color ON color.color_id = stock.color_color_id
                INNER JOIN size ON size.size_iid = stock.size_size_iid
                WHERE stock.stock_id = :stockID";
    $db->query($query);
    $db->bind(":stockID", $stockID);
    return $db->resultSet()[0];
}
function getImage($productID){
    $db = new \database\Database();
    $q = "SELECT * FROM product_images INNER JOIN  product_images_has_product ON product_images.image_id = product_images_has_product.product_images_image_id WHERE product_product_id = :productID LIMIT 1";
    $db->query($q);
    $db->bind(":productID", $productID);
    $results  = $db->resultSet();
    if(count($results )> 0){
        return  $results[0]['path'];
    }else{
        return "fuck.png";
    }
}

function addingToOrder($orderID,$shippingAddress,$shippingCity,$shippingProvince,$shippingCountry,$postalCode,$amount,$stocks){

//    addOrder Table
    global $ORDERING;
    $db = new \database\Database();
    $query = "INSERT INTO `order` ( `order_id`,`shipping_address`, `shipping_city`, `shipping_province`, `shipping_district`, `shipping_country`, `postal_code`, `amount`, `user_email`) VALUES 
                                    ( :orderID,:shippingAddress, :city,:province, :district,:country, :postalCode, :amount, :email);";
    $db->query($query);
    $db->bind(":orderID", $orderID);
    $db->bind(":shippingAddress", $shippingAddress);
    $db->bind(":city", $shippingCity);
    $db->bind(":province", $shippingProvince);
    $db->bind(":district", $shippingCountry);
    $db->bind(":country", $shippingCountry);
    $db->bind(":postalCode", $postalCode);
    $db->bind(":amount", $amount);
    $db->bind(":email", $_SESSION['user_email']);
    $db->execute();
    for($i = 0 ; $i < count($stocks);$i++){
        $item = $stocks[$i];
        $db = new \database\Database();
        $query = "INSERT INTO `order_has_stock` (`order_order_id`, `stock_stock_id`, `order_qty`) VALUES (:orderID,:stockID,:qty);";
        $db->query($query);
        $db->bind(":orderID", $orderID);
        $db->bind(":stockID", $item->stock_id);
        $db->bind(":qty", $item->qty);
        $db->execute();
    }

    $db2 = new \database\Database();
    $query2 = "INSERT INTO `order_status` (`status`, `date_time`, `order_order_id`) VALUES (:status, :dateTime,:orderID);";
    $db2->query($query2);
    $db2->bind(":status", $ORDERING);
    $db2->bind(":dateTime", date("Y-m-d H:i:s"));
    $db2->bind(":orderID", $orderID);
    $db2->execute();






}
function emptyCart(){
    $db = new \database\Database();
    $query = "DELETE FROM `cart` WHERE `user_email` = :email";
    $db->query($query);
    $db->bind(":email", $_SESSION['user_email']);
    $db->execute();
}


if(!isset($_SESSION['user_email'])){
    $obj->message = "authentication failed";
    $obj->statusCode = $ERROR;
}else if(!isset($_GET['addressID'])){
    $obj->message = "Address Error";
    $obj->statusCode = $ERROR;
}else if($_GET['addressID'] ==0 ){
    $obj->message = "invalid address";
    $obj->statusCode = $ERROR;
}
else {
    $email = $_SESSION['user_email'];
    $db = new \database\Database();
    $q = "SELECT * FROM cart WHERE user_email = :email";
    $db->query($q);
    $db->bind(":email", $email);
    $results = $db->resultSet();


    $addressDB = new \database\Database();
    $addressq = "SELECT * FROM address WHERE address.address_id = :id";
    $addressDB->query($addressq);
    $addressDB->bind("id",$_GET['addressID']);
    $addressResults = $addressDB->resultSet();
    $addressResult = $addressResults[0];

    $productsCount = 0;
    $itemsCount = 0;
    $shippingAddress =$addressResult['address'];
    $subTotal = 0;
    $shippingTotal = 0;
    $total = 0;
    $stocks = array();
    for ($i = 0; $i < count($results); $i++) {
        $cartItem = $results[$i];
        $stock = getStock($cartItem['stock_stock_id']);

        $image = getImage($stock['product_product_id']);

        $shippingTotal = intval($shippingTotal) + (intval($stock['shipping_cost']) * intval($cartItem['cart_qty']));
        $itemsCount += intval($cartItem['cart_qty']);
        $productsCount += 1;
        $subTotal = intval($subTotal) + (intval($stock['stock_price']) * intval($cartItem['cart_qty']));


        $orderStockQty = new stdClass();
        $orderStockQty->stock_id = $stock['stock_id'];
        $orderStockQty->qty = $cartItem['cart_qty'];
        array_push($stocks,$orderStockQty);
    }
    $total = $subTotal + $shippingTotal;
    $orderID =mt_rand(100000, 999999);
    $city = $addressResult['city'];
    $merchant_secret = "MzA3MjI5NTU4MzE2Mjg4MDMzNzQyNjU2ODg3ODIzOTg1MTI5MDEy";

    $payment = new stdClass();
    $payment->sandbox = true;
    $payment->merchant_id = "1221323";    // Replace your Merchant ID
    $payment->return_url = "return.php?orderID=".$orderID;     // Important
    $payment->cancel_url = "cansel.php?orderID=".$orderID;     // Important
    $payment->notify_url = "http://sample.com/notify";
    $payment->order_id = strval($orderID);
    $payment->items = "items in $orderID";
    $payment->amount = strval($total);
    $payment->currency = "LKR";
    $payment->first_name = $_SESSION['user_name'];
    $payment->last_name = $_SESSION['user_name'];
    $payment->email = $email;
    $payment->phone = $addressResult['contact'];
    $payment->address = $shippingAddress;
    $payment->city = $city;
    $payment->country = $addressResult['country'] ;
    $payment->delivery_address =$shippingAddress;
    $payment->delivery_city = $city;
    $payment->delivery_country = $addressResult['country'];
    $payment->custom_1 = "";
    $payment->custom_2 = "";
    $_SESSION['last_order_id'] = $payment->order_id;

    $hash = strtoupper(
        md5(
            $payment->merchant_id.
            $orderID .
            number_format($total, 2, '.', '') .
            $payment->currency .
            strtoupper(md5($merchant_secret))
        )
    );
    $payment -> hash = $hash;

    $obj ->payment = $payment;
    $shippingProvince = $addressResult['province'];
    $postalCode = $addressResult['postalcode'];
    addingToOrder($orderID,$shippingAddress,$payment->city,$shippingProvince,$payment->delivery_country,$postalCode,$payment->amount,$stocks);
    emptyCart();
    echo json_encode($obj);

}

