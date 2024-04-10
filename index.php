<?php
global $APP_NAME;
require_once "const/AppStrings.php";
require_once "database/Database.php";
session_start();
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
    <?php require_once "./components/carasol.php" ?>
    <?php require_once "./components/productItem.php" ?>
    <?php require_once "./components/whishList.php" ?>
    <?php require_once "./components/cart.php" ?>



    <div class="row mt-5 mb-5">
        <div class="col-12">
            <div class="row fw-bold text-capitalize">
                <p class=" fs-4 ms-3">tops</p>
            </div>

            <div class="row" id="productContainer" >
                <?php
                $limit = 8;
                $db = new \database\Database();
                $query = "SELECT * FROM product limit $limit";
                $db->query($query);
                $result = $db->resultSet();

                foreach ($result as $row) {
                    echo productItemComponent($row);
                }

                ?>







            </div>


            <div class="row mb-5 mt-5 d-none" id="loadingIndicator">
                <div class="col-12  justify-content-center align-items-center d-flex">
                    <div class='spiner-here' style="height: 50px;width: 50px;"> </div>
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
                var  limit = 5;
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
    <?php
    require_once  './components/footer.php';
    ?>


</div>

<?php
require './components/Toasts.php';
?>


</body>
</html>