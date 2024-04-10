<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
session_start();
$obj = new stdClass();
$obj->items = '';
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

if(!isset($_SESSION['user_email'])){
    $obj->message = "authentication failed";
    $obj->statusCode = $ERROR;
}else{
    $email  =  $_SESSION['user_email'];
    $db = new \database\Database();
    $q = "SELECT * FROM cart WHERE user_email = :email";
    $db->query($q);
    $db->bind(":email",$email);
    $results  = $db->resultSet();

    $productsCount = 0;
    $itemsCount = 0;
    $shippingAddress = "moroththa,madahapola 60552 Sri Lanka";
    $subTotal = 0;
    $shippingTotal = 0;
    $total = 0;

    for($i = 0; $i < count($results); $i++){
        $cartItem = $results[$i];
        $stock  = getStock($cartItem['stock_stock_id']);
        $image  = getImage($stock['product_product_id']);

        $shippingTotal = intval($shippingTotal) + (intval($stock['shipping_cost'] )* intval($cartItem['cart_qty']));
        $itemsCount += intval($cartItem['cart_qty']);
        $productsCount += 1;
        $subTotal = intval($subTotal) + (intval($stock['stock_price']) * intval($cartItem['cart_qty']));

        ob_start();
        ?>

        <div class="row">
            <div class="col-5">
                <img src="../<?php echo $image?>" class="img-thumbnail" alt="no" srcset="">
            </div>
            <div class="col-7">

                <div class="row">

                    <div class="col-12 fw-bold"><?php echo $stock['product_name']?></div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-6 mt-2">
                        Color: <span class="fw-bold"><?php echo $stock['color_name']?></span>
                        <div class="rounded-circle  border ms-1  " style="height: 30px; width: 30px; background-color:<?php echo $stock['color_hex']?>;"></div>

                    </div>
                    <div class="col-6 mt-4">
                        Size: <span class="bg-black fw-bold  text-white p-1 rounded"><?php echo $stock['size']?></span>
                    </div>

                    <div class="col-12">
                        <hr>
                    </div>


                    <div class="col-lg-6 col-4">
                        <div class="row">
                           <span>Quentity :  <?php echo  $cartItem['cart_qty']?></span>

                        </div>
                    </div>


                    <div class="col-8 col-lg-6 mt-3">
                        <div class="row">

                            <div class="col-3 offset-2">
                                <button class="btn btn-dark" onclick="removeFromCart('<?php echo $cartItem['idcart']?>')"><i class="bi bi-trash-fill"></i></button>

                            </div>


                            <div class="col-3">
                                <button class="btn btn-primary" onclick="window.location.href = 'singleProduct.php?pid=<?php echo $stock['product_product_id']?>'"><i class="bi bi-eye-fill "></i></button>
                            </div>



                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">

                            </div>
                        </div>
                    </div>



                </div>





            </div>

            <div class="col-12">
                <hr>
            </div>


        </div>

<?php
        $obj->items .= ob_get_clean();
    }


    $obj->subTotal = $subTotal;
    $obj->productsCount =  $productsCount;
    $obj->itemsCount = $itemsCount;
    $obj->shippingTotal = $shippingTotal;
    $obj->shippingAddress = $shippingAddress;
    $obj->total =  $subTotal+$shippingTotal;

}


echo  json_encode($obj);