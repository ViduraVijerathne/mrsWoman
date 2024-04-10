
<?php
require_once '../const/statesCodes.php';
require_once '../const/auth.php';
require_once "../database/database.php";
require_once "../const/orderStatus.php";
require_once "../components/error404.php";
$obj = new stdClass();
$obj -> message = "done";
$obj -> statusCode = 1;
$obj -> body = "";

if (isAdmin()) {

ob_start();
?>
<div class="row mt-5">
    <div class="col-12">
        <p class="h3 fw-bold">Add New  Product</p>
    </div>

    <div class="col-4 mt-3">
        <input id="productName" type="text" placeholder="Product Name" class="form-control" maxlength="100">
        <textarea type="text" id="productDescription" placeholder="Product Description" rows="10" maxlength="500" class="form-control mt-2"></textarea>

    </div>
    <div class="col-4">
        <p class="h5 fw-bold"> Add  Product Images </p>
        <label class="btn btn-dark" for="productImages_uploader">Select Product Images</label>
        <input type="file" hidden="hidden"  onchange="loadAdminAddProductImageList()" name="productImages_uploader" id="productImages_uploader" accept="image/*" multiple>


        <div class="row p-1 border mt-1 rounded-3 bg-light" id="adminAddProductImageListComponentContainer">
            <!-- one item-->
            <!--                                <div class="col-12">-->
            <!--                                    <div class="row m-1 p-1 bg-black rounded-2 text-light">-->
            <!--                                        <div class="col-3">-->
            <!--                                            <img src="./src/images/product_images/jacket%20(1).webp" style="height: 100px" class="img-fluid" alt="">-->
            <!--                                        </div>-->
            <!--                                        <div class="col-7 text-break fw-lighter">-->
            <!--                                            produckokokokokokokkokokokokokokokkokokokokokt1.png-->
            <!--                                        </div>-->
            <!--                                        <div class="col-1 d-flex justify-content-center align-items-center">-->
            <!--                                            <button class="btn-danger btn">-->
            <!--                                                <i class="bi bi-trash-fill"></i>-->
            <!--                                            </button>-->
            <!--                                        </div>-->
            <!--                                    </div>-->
            <!--                                </div>-->
        </div>
    </div>
    <div class="col-3 mt-3">
        <p class="h5 fw-bold">Product Images View</p>
        <!-- carosal start -->
        <div class="row">
            <div class="col-12">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">

                        <div class="carousel-item active" data-bs-interval="3000">
                            <img src="./src/images/sample_product_image.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="./src/images/sample_product_image.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item" data-bs-interval="3000">
                            <img src="./src/images/sample_product_image.png" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- carosal end -->
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <p class="h4 fw-bold">Add Product Stock</p>
    </div>

    <div class="col-2">
        <p class="fw-bold mt-2">Select Product Stock Size</p>
        <select name="AddProductSize" id="AddProductSize" class="form-control">
            <option value="0" class="form-control">SIZE</option>
            <?php
            $db = new \database\Database();
            $query = "SELECT * FROM size";
            $db->query($query);
            $result = $db->resultSet();
            foreach ($result as $row) {
               ?>
                <option value="<?= $row['size_iid']?>"><?= $row['size']?></option>
                <?php
            }

            ?>

        </select>
    </div>

    <div class="col-2">
        <p class="fw-bold mt-2">Select Product Stock Color</p>
        <input id="AddProductColor" type="color" class="form-control">
    </div>
    <div class="col-2">
        <p class="fw-bold mt-2">Enter  Color Name</p>
        <input id="addProductColorName" type="text" class="form-control">
    </div>
    <div class="col-2">
        <p class="fw-bold mt-2">Enter  Quantity</p>
        <input  id="addProductQty" type="number" class="form-control">
    </div>
    <div class="col-1">
        <p class="fw-bold mt-2">Price</p>
        <input id="addProductPrice" type="number" class="form-control">
    </div>
    <div class="col-1">
        <p class="fw-bold mt-2">Delivery Fee</p>
        <input type="number"  id="addProductDeliveryFree" class="form-control">
    </div>
    <div class="col-1 d-flex justify-content-center align-items-end">
        <button onclick="addNewProductStock()" class="btn-dark btn">ADD</button>
    </div>
</div>

<div class="row p-1 border mt-1 rounded-3 bg-light" id="AdminAddProductStockListContainer">
    no item found!
    <!--One Item -->
    <!--                        <div class="col-12 border border-dark border-1 rounded p-1 m-1 ">-->
    <!--                            <div class="row">-->
    <!--                                <div class="col-2 text-center fw-bold d-flex justify-content-center align-items-center">-->
    <!--                                    SM-->
    <!--                                </div>-->
    <!--                                <div class="col-2 text-center fw-bold d-flex justify-content-center align-items-center">-->
    <!--                                    <div class="rounded-circle" style="width: 50px;height: 50px;background-color: #0a58ca"></div>-->
    <!--                                </div>-->
    <!--                                <div class="col-2 text-center text-uppercase fw-bold d-flex justify-content-center align-items-center">-->
    <!--                                    Black-->
    <!--                                </div>-->
    <!--                                <div class="col-2 text-center text-uppercase fw-bold d-flex justify-content-center align-items-center">-->
    <!--                                    x100-->
    <!--                                </div>-->
    <!--                                <div class="col-1 text-center text-uppercase fw-bold d-flex justify-content-center align-items-center">-->
    <!--                                    $100-->
    <!--                                </div>-->
    <!--                                <div class="col-1 text-center  d-flex text-uppercase fw-bold justify-content-center align-items-center">-->
    <!--                                    $10-->
    <!--                                </div>-->
    <!--                                <div class="col-1 text-center  d-flex text-uppercase fw-bold justify-content-center align-items-center">-->
    <!--                                    <button class="btn-danger btn">-->
    <!--                                        <i class="bi bi-trash-fill"></i>-->
    <!--                                    </button>-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                        </div>-->

</div>
<hr>
<div class="row">
    <button class="btn btn-dark" onclick="adminAddNewProduct()" >Finish</button>
</div>

<!--                    <div class="spinner">-->
<!---->
<!--                    </div>-->


<?php
$obj->body = ob_get_clean();
}else{
    $obj->body = showAuthFailure();
}
echo json_encode($obj);

?>