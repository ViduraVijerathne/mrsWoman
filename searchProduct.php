<?php
global $APP_NAME;
require_once "const/AppStrings.php";
require_once "database/Database.php";
session_start();

$priceFrom = isset($_GET['priceFrom']) ? $_GET['priceFrom'] : null;
$priceTo = isset($_GET['priceTo']) ? $_GET['priceTo'] : null;
$categoryID = isset($_GET['categoryID']) ? $_GET['categoryID'] : null;
$colorName = isset($_GET['colorName']) ? $_GET['colorName'] : null;
$sortOrder = isset($_GET['sortPrice']) && $_GET['sortPrice'] == 'HtoL' ? 'DESC' : 'ASC';
$keywords = isset($_GET['keyWords']) ? strtolower($_GET['keyWords']) : null;

$sql = "SELECT * FROM product
        INNER JOIN categories ON categories.cat_id = product.category_id
        INNER JOIN stock ON stock.product_product_id = product.product_id
        INNER JOIN color ON color.color_id = stock.color_color_id
        WHERE 1 = 1";

// Add conditions based on search variables
if (!is_null($priceFrom)) {
    $sql .= " AND stock.stock_price >= $priceFrom";
}
if (!is_null($priceTo) && $priceTo > 0) {
    $sql .= " AND stock.stock_price <= $priceTo";
}

if (!is_null($categoryID) && $categoryID > 0) {
    $sql .= " AND product.category_id = $categoryID";
}

if (!is_null($colorName) && $colorName != 'none' && $colorName != 0) {
    $sql .= " AND color.color_name = '$colorName'";
}
if (!is_null($keywords) && strlen($keywords) > 0) {
    $sql .= " AND (LOWER(product.product_name) LIKE '%{$keywords}%' OR LOWER(product.product_description) LIKE '%{$keywords}%')";
}

// Apply sorting
$sql .= " ORDER BY stock.stock_price $sortOrder";

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="./css/styles.css" class="css">
        <script src="css/bootstrap/js/bootstrap.js"></script>
        <script src="js/script.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

        <script src="js/app_payment.js"></script>
        <title><?php echo $APP_NAME ?></title>
    </head>
<body id="body">
<div class="container-fluid">
    <?php require_once "./components/NavBar.php" ?>
    <?php require_once "./components/productItem.php" ?>
    <?php require_once "./components/whishList.php" ?>
    <?php require_once "./components/cart.php" ?>
    <?php require_once "./components/searchWithFiltersModal.php" ?>

    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="row fw-bold text-capitalize">
            </div>
            <div class="row" id="productContainer">
                <?php
                $db = new \database\Database();
                $db->query($sql);
                $result = $db->resultSet();
                if (count($result) == 0) {
                    echo "<div class='fw-bold col-12 text-center fs-4'> No items Found</div>";
                }
                foreach ($result as $row) {
                    echo productItemComponent($row);
                }
                ?>
            </div>

            <div class="row mb-5 mt-5 d-none" id="loadingIndicator">
                <div class="col-12 justify-content-center align-items-center d-flex">
                    <div class='spiner-here' style="height: 50px;width: 50px;"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <button class="btn btn-dark" id="load">
                        Load More
                    </button>
                </div>
            </div>

            <script>
                var limit = 5;
                document.getElementById('load').addEventListener('click', function() {
                    document.getElementById('loadingIndicator').classList.remove('d-none');
                    var xhr = new XMLHttpRequest();
                    limit = limit + 4;
                    xhr.open('GET', 'load_more_products.php?limit=' + limit, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var products = xhr.responseText;
                            var productContainer = document.getElementById('productContainer');
                            productContainer.innerHTML = products;
                            document.getElementById('loadingIndicator').classList.add('d-none');
                        }
                    };
                    xhr.send();
                });
            </script>
        </div>
    </div>
    <?php require_once './components/footer.php'; ?>
</div>
<?php require './components/Toasts.php'; ?>
</body>
</html>
