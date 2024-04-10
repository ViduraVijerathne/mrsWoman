<?php
require_once "database/database.php";
if(!isset($_SESSION)){
    session_start();
}
function loadImage($pid)
{
    $db = new database\Database();
    $query = "SELECT * FROM product_images
                INNER JOIN product_images_has_product
                ON product_images.image_id = product_images_has_product.product_images_image_id
                WHERE product_images_has_product.product_product_id = :pid";

    $db->query($query);
    $db->bind(':pid', $pid);
    return $db->resultSet();
}

function loadStock($pid)
{
    $db = new database\Database();
    $query = "SELECT * FROM stock
                INNER JOIN color 
                ON color.color_id = stock.color_color_id
                INNER JOIN size
                ON size.size_iid = stock.size_size_iid
                WHERE stock.product_product_id  = :pid";

    $db->query($query);
    $db->bind(':pid', $pid);
    return $db->resultSet();
}

function isThisProductInWhishList($productID){

    if(isset($_SESSION['user_email'])){
        $db = new database\Database();
        $query = "SELECT * FROM whish_list WHERE whish_list.user_email = :email AND whish_list.product_product_id = :pid";
        $db->query($query);
        $db->bind(':email', $_SESSION['user_email']);
        $db->bind(':pid', $productID);
        $result =  $db->resultSet();
        if(count($result)>0){
            return  true;
        }else{
            return false;
        }

    }else {
        return  false;
    }

}
function productItemComponent($p)


{

    $pId = $p['product_id'];
    $images = loadImage($pId);
    $stocks = loadStock($pId);

    ?>
    <div class="col-12 col-lg-3"  id="productMainCard_<?php echo $pId ?>">
        <!--        quick view product-->
        <div class="row shadow border rounded-2 m-2 pb-5 " id="productQuickViewCard_<?php echo $pId ?>">
            <div class="col-12">
                <div id="productImageGallery_<?php echo $pId; ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php
                        for ($i = 0; $i < count($images); $i++) {

                            ?>
                            <button type="button" data-bs-target="#carouselExampleCaptions"
                                    data-bs-slide-to="<?php echo $i ?>" <?php echo $i == 0 ? 'class="active" aria-current="true"' : '' ?>
                                    aria-label="Slide <?php echo $i; ?>"></button>

                            <?php

                        }

                        ?>
                        <!--                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>-->
                        <!--                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>-->
                    </div>
                    <div class="carousel-inner">
                        <?php
                        foreach ($images as $image) {

                            ?>
                            <div class="carousel-item active" data-bs-interval="3000">
                                <img src="../<?php echo $image['path'] ?>" class="d-block w-100" alt="...">
                            </div>
                            <?php
                        }

                        ?>

                        <!--                            <div class="carousel-item" data-bs-interval="3000">-->
                        <!--                                <img src="../src/images/product_images/jacket%20(2).webp" class="d-block w-100" alt="...">-->
                        <!--                            </div>-->
                        <!--                            <div class="carousel-item" data-bs-interval="3000">-->
                        <!--                                <img src="../src/images/product_images/jacket%20(3).webp" class="d-block w-100" alt="...">-->
                        <!--                            </div>-->
                    </div>
                    <button class="carousel-control-prev" type="button"
                            data-bs-target="#productImageGallery_<?php echo $pId; ?>" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button"
                            data-bs-target="#productImageGallery_<?php echo $pId; ?>" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <div class="col-12 fw-bold text-center text-capitalize fs-5" id="PName_1">
                    <?php echo($p['product_name']); ?> <br>
                    $ <?php
                    for($priceSmalI = 0 ; $priceSmalI <count($stocks); $priceSmalI++) {
                        $stock = $stocks[$priceSmalI];
                        if($priceSmalI == 0){
                             echo $stock['stock_price'];
                        }
                    }
                    ?>
                </div>

                <div class="row d-flex justify-content-between">
                    <div class="col-1">
                        <button class="btn btn-light " onclick="addToWhishListInHome('<?php echo $pId?>')">
                            <i id="heartIcon_1_<?php echo $pId?>" class="bi  <?php echo isThisProductInWhishList($pId) ? 'bi-heart-fill' : 'bi-heart'?> fs-4 fw-bold text-danger "></i>
                        </button>
                    </div>
                    <div class="col-10">

                        <button class="btn btn-dark w-100 mt-2" onclick="ViewProductDescribeView('<?php echo $pId ?>')">
                            View
                        </button>
                    </div>
                </div>
            </div>


        </div>
        <!--        discribe view product view product-->
        <div class="row shadow border rounded-2 m-2 pb-5 d-none" id="productDescribeViewCard_<?php echo $pId ?>">
            <div class="col-12 col-lg-3" id="item_view_1">
                <!-- images -->
                <div class="row m-1 ">
                    <div class="col-12">
                        <!-- carosal start -->
                        <div class="row">
                            <div class="col-12">
                                <div id="product_<?php echo $pId ?>" class="carousel slide row "
                                     data-bs-ride="carousel">
                                    <div class="carousel-indicators col-12">
                                        <?php
                                        for ($i = 0; $i < count($images); $i++) {

                                            ?>
                                            <button type="button" data-bs-target="#carouselExampleCaptions"
                                                    data-bs-slide-to="<?php echo $i ?>" <?php echo $i == 0 ? 'class="active" aria-current="true"' : '' ?>
                                                    aria-label="Slide <?php echo $i; ?>"></button>

                                            <?php

                                        }

                                        ?>
                                        <!--                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-label="Slide 1" aria-current="true"></button>-->
                                        <!--                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2" class=""></button>-->
                                        <!--                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>-->

                                    </div>
                                    <div class="carousel-inner">
                                        <?php
                                        foreach ($images as $image) {

                                            ?>
                                            <div class="carousel-item active" data-bs-interval="3000">
                                                <img src="../<?php echo $image['path'] ?>" class="d-block w-100"
                                                     alt="...">
                                            </div>
                                            <?php
                                        }

                                        ?>
                                        <!--                                        <div class="carousel-item active" data-bs-interval="3000">-->
                                        <!--                                            <img src="../src/images/product_images/jacket%20(1).webp" class="d-block w-100 " alt="..." id="ProductCarosal_img0_1">-->
                                        <!---->
                                        <!---->
                                        <!--                                        </div>-->
                                        <!--                                        <div class="carousel-item" data-bs-interval="3000">-->
                                        <!--                                            <img src="../src/images/product_images/jacket%20(2).webp" class="d-block w-100 " alt="..." id="ProductCarosal_img1_1">-->
                                        <!---->
                                        <!---->
                                        <!--                                        </div>-->
                                        <!--                                        <div class="carousel-item" data-bs-interval="3000">-->
                                        <!--                                            <img src="../src/images/product_images/jacket%20(3).webp" class="d-block w-100 " alt="..." id="ProductCarosal_img1_1">-->
                                        <!---->
                                        <!---->
                                        <!--                                        </div>-->
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                            data-bs-target="#product_<?php echo $pId ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                            data-bs-target="#product_<?php echo $pId ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>

                                        <span class="visually-hidden">Next</span>
                                    </button>

                                    <div class="row position-absolute bottom-0 d-flex justify-content-center align-items-center d-none"
                                         id="BtnView_1">
                                        <a href="#item_1" class="text-decoration-none">
                                            <button class="btn btn-light border-1 d-grid mb-5 ms-2 col-11 fw-bold d-none"
                                                    onclick="QuickviewProduct('1')" id="viewBtn_1">View
                                            </button>
                                        </a>
                                    </div>


                                </div>


                            </div>


                        </div>
                        <!-- carosal end -->
                    </div>


                </div>
                <!-- images -->

                <!-- Description -->
                <div class="row">
                    <div class="col-12 fw-bold text-center text-capitalize fs-5 d-none" id="PName_1">
                        <?php echo $p['product_name']; ?><br>
                        $ <?php
                        foreach ($stocks as $stock) {
                            echo $stock['stock_price'];
                        } ?>
                    </div>
                    <!-- Add To Heart Whish List -->
                    <div class="col-12">
                        <button class="btn btn-light " onclick="addToWhishListInHome('<?php echo $pId?>')">
                            <i id="heartIcon_2_<?php echo $pId?>" class="bi  <?php echo isThisProductInWhishList($pId) ? 'bi-heart-fill' : 'bi-heart'?> fs-4 fw-bold text-danger "></i>
                        </button>
                    </div>


                </div>
                <!-- Description -->
            </div>


            <div class="col-lg-9 col-12" id="itemMoreView_1">
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-danger  m-3" onclick="ViewProductQuickView('<?php echo $pId ?>')"><i
                                    class="bi bi-x-lg"></i></button>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-12 col-lg-6 border-end">
                        <div class="row mt-3" id="productSizeButtonGroup_<?php echo  $pId?>">
                            <?php
                            $sizes = array();
                            foreach ($stocks as $stock) {

                                if(!in_array($stock['size_iid'],$sizes)){
                                    array_push($sizes,$stock['size_iid']);
                                ?>
                                <button onclick="SelecteProductChangeSize('<?php echo  $pId?>','<?php echo $stock['size_iid']?>')" id="size_<?php echo  $pId.'_'.$stock['size_iid']?>"
                                        class="btn  col-1 ms-3 fw-bold text-uppercase btn-outline-dark sizebtn_<?php echo  $pId?> "><?php echo $stock['size'];?>
                                </button>

                                <?php

                                }
                            } ?>


                        </div>
                        <div class="row mt-3">

                            <div class="col-12 fs-5">Color: <?php echo isThisProductInWhishList($pId)?> <span id="colorName_<?php echo  $pId?>" class="fw-bold text-uppercase">*</span></div>

                            <div class="col-12">
                                <div class="row ms-2" id="productColorButtonGroup_<?php echo  $pId?>">

                                    <?php
                                    foreach ($stocks as $stock){

                                        ?>
                                        <div id="colorBtn_<?php echo  $pId?>_<?php echo $stock['color_id']?>" onclick="SelectedProductChangeColor('<?php echo  $pId?>','<?php echo $stock['color_id']?>')" class="rounded-circle  border ms-1  border-5 de-active-color-circle"
                                             style=" background-color:<?php echo  $stock['color_hex']?>;"></div>


                                        <?php
                                    } ?>


                                    <!-- <div class="rounded-circle  border ms-1  " style="height: 30px; width: 30px; background-color:#0f0000;"></div>
                                    <div class="rounded-circle  border ms-1  " style="height: 30px; width: 30px; background-color:#00f000;"></div>
                                    <div class="rounded-circle  border ms-1  " style="height: 30px; width: 30px; background-color:#00ffff;"></div> -->
                                </div>
                            </div>
                        </div>
 <?php
                                $qty = 0;
                                foreach ($stocks as $stock){
                                    $qty += $stock['qty'];
                                }?>
                        <div class="row mt-4">
                            <div class="col-12">



                                <input type="text" id="allitemQty_1" value="" hidden="">


                                <div class="text-capitalize">

                                    <span class="fw-bold" id="qty_label_<?php echo $pId?>"><?php echo $qty ?></span>
                                    items Available!
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <hr>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-capitalize " style="letter-spacing:2px;">
                                <?php echo $p['product_description'] ?>
                                <!--                                Introducing the Sydney Knit Tee – the epitome of casual comfort and timeless style! Crafted from high-quality knit fabric, this short sleeve tee is designed to provide a soft and breathable feel, making it a versatile and essential piece for your everyday wardrobe. The short sleeves add a touch of laid-back ease, creating the perfect go-to tee for warmer days or as a versatile layering option. The classic silhouette is universally flattering, offering comfort without compromising on style, making it an ideal choice for various occasions. Whether you're pairing it with jeans for a relaxed weekend look or tucking it into a skirt for a more polished ensemble, this tee serves as a versatile canvas for expressing your personal style! Available in 4 colors.                          -->
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="row">
                            <div class="col-12 fw-bold fs-4 " style="letter-spacing:2px;">
                                <?php echo $p['product_name'] ?>                         </div>
                        </div>

                        <div class="row ">
                            <div class="col-12 fw-bold fs-5" id="priceTag_<?php echo  $pId?>">

                                $ <?php
                                for ($priceStockI = 0 ; $priceStockI < count($stocks); $priceStockI++){
                                    $stock = $stocks[$priceStockI];
                                    if($priceStockI == 0){
                                        echo $stock['stock_price'];
                                    }

                                } ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 fw-bold fs-4">Quentity</div>
                            <div class="col-3 ms-3">
                                <input type="number" name="" id="quentity_<?php echo $pId?>" class="form-control" placeholder="Quentity"
                                       value="1">
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 fw-bold text-black-50">
                                <?php
                                $ship = 0;
                                for($shipI = 0 ; $shipI < count($stocks);$shipI++){
                                    if($shipI == 0 ){
                                        $ship = $stocks[$shipI]['shipping_cost'];
                                    }
                                }

                                ?>
                                Shipping Cost : <span id="shippingCostTag_<?php echo $pId?>">$ <?php echo $ship?></span>
                            </div>

                        </div>

                        <div class="row mt-5" id="product_<?php echo $pId ?>">

                            <button class="btn btn-outline-dark d-grid col-10 offset-1 fw-bold"
                                    onclick="AddToCart('<?php echo  $pId?>')">Add To Cart
                            </button>
                            <button class="btn btn-dark d-grid  col-10 offset-1 mt-3 fw-bold" type="submit"
                                    id="payhere-payment" onclick="buyNow('<?php echo $pId ?>')">Buy Now
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <?php

}

?>