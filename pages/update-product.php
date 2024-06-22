<?php


require_once '../const/statesCodes.php';
require_once '../const/auth.php';
require_once "../database/database.php";
require_once "../const/orderStatus.php";
require_once "../components/error404.php";
$obj = new stdClass();
$obj->message = "done";
$obj->statusCode = 1;
$obj->body = "";

if (isAdmin()) {


    if(isset($_GET['pid'])){
        $db = new \database\Database();
        $query ="SELECT * FROM product WHERE product.product_id = :pid";
        $db->query($query);
        $db->bind(":pid", $_GET['pid']);
        $result =  $db->resultSet();
        if(count($result)>0){
            $row = $result[0];

        $productName  = $row['product_name'];
        $productDesc = $row['product_description'];
        $productCatID = $row['category_id'];

        ob_start();
        ?>
        <h1>Update Product</h1>
        <div class="row ">
           <span class="col-12 text-center fw-bold fs-3"> <?php echo  $productName?></span>
        </div>

            <div class="row">
                <div class="col-6 mt-3">
                    <input id="productName" type="text" placeholder="Product Name" class="form-control" maxlength="100" value="<?php echo $productName?>">
                    <textarea type="text" id="productDescription" placeholder="Product Description" rows="10" maxlength="500" onload="loadDescription()"
                              class="form-control mt-2">
                <?php echo $productDesc?>
            </textarea>

                    <span class="mt-5">Select Category</span>
                    <select class="form-control" id="catergoryOption">

                        <?php
                        $db = new \database\Database();
                        $query = "SELECT * FROM categories";
                        $db->query($query);
                        $result = $db->resultSet();
                        foreach ($result as $row) {
                            $isSelected = ($row['cat_id'] == $productCatID) ? ' selected' : ''; // Check if it's the selected category
                            echo '<option value="' . $row['cat_id'] . '"' . $isSelected . '>' . $row['category'] . '</option>';
//                    echo  '<option value="'.$row['cat_id'].'">'.$row["category"].'</option>';
                        }

                        ?>
                    </select>
                </div>
                <div class="col-3 offset-3 mt-3">
                    <p class="h5 fw-bold">Product Images View</p>
                    <!-- carosal start -->
                    <div class="row">
                        <div class="col-12">
                            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                            class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                            aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                            aria-label="Slide 3"></button>
                                </div>
                                <div class="carousel-inner">
                                    <?php
                                    $query = "SELECT * FROM product_images_has_product INNER JOIN product_images ON product_images_has_product.product_images_image_id = product_images.image_id WHERE product_product_id = :pid";
                                    $db = new \database\Database();
                                    $db->query($query);
                                    $db->bind(":pid", $_GET['pid']);
                                    $result = $db->resultSet();
                                    foreach ($result as $row) {
                                        ?>
                                        <div class="carousel-item active" data-bs-interval="3000">
                                            <img src="./<?php echo $row['path']?>" class="d-block w-100" alt="...">
                                        </div>
                                        <?php
                                    }

                                    ?>


                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                                        data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                                        data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- carosal end -->
                </div>

            </div>




        <?php
    }else{
            $obj->body ="INVALID PRODUCT ID";
            $obj->message = "INVALID PRODUCT ID";
            $obj->statusCode = 0;
        }
    }else{
        $obj->body ="INVALID PRODUCT ID";
        $obj->message = "INVALID PRODUCT ID";
        $obj->statusCode = 0;
    }


$obj->body = ob_get_clean();
} else {
    $obj->body = showAuthFailure();
}
echo json_encode($obj);


