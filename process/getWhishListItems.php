<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";

session_start();
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

$obj = new stdClass();
$obj -> items = "";
$obj -> itemsCount = 0;
if(!isset($_SESSION['user_email'])){
    $obj->message = "Please Login";
    $obj->statusCode = $ERROR;
}else{
    $email = $_SESSION['user_email'];
    $db = new \database\Database();
    $q = "SELECT * FROM whish_list  INNER JOIN product  ON product.product_id = whish_list.product_product_id WHERE whish_list.user_email =:email";
    $db->query($q);
    $db->bind(":email", $email);
    $results  = $db->resultSet();
    $obj -> itemsCount = count($results);

for($i = 0; $i <count($results);$i++){
    $whish = $results[$i];
    $productID = $whish['product_id'];
    $productName = $whish['product_name'];
    $description = $whish['product_description'];
    $image = getImage($productID);
    ob_start(); // Start output buffering
?>
    <!-- One cart item -->
    <div class="row" >
        <div class="col-5">
            <img src="../<?php echo $image?>" class="img-thumbnail" style="height: 200px;" alt="no" srcset="">
        </div>
        <div class="col-7">

            <div class="row">

                <div class="col-12 fw-bold"><?php echo $productName?></div>
                <div class="col-12">
                    <hr>
                </div>
                <div class="col-12 mt-2">
                    Description: <span class="fw-bold"><?php echo  $description?></span>


                </div>

                <div class="col-12">
                    <hr>
                </div>



                <div class="col-8 col-lg-6 mt-3">
                    <div class="row">

                        <div class="col-3 offset-2">
                            <button class="btn btn-danger" onclick="removeFromWhishList('<?php echo $productID?>')"><i class="bi bi-trash-fill"></i></button>

                        </div>

                        <div class="col-3">
                            <button class="btn btn-primary" onclick="window.location.href = 'singleProduct.php?pid=<?php echo $productID?>'"><i class="bi bi-eye-fill "></i></button>
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
}

echo json_encode($obj);
?>

