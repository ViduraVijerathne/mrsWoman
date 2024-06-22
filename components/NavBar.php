<?php
$email = "";
$isLogin = false;
if(isset($_SESSION['user_email']) && $_SESSION['user_password']){
    $email = $_SESSION['user_email'];
    $isLogin = true;
}
$keywords = "";
if(isset($_GET['keyWords'])){
    $keywords = strtolower($_GET['keyWords']);
}


?>
<div class="row sticky-top shadow ">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><img src="./src/logo.png" alt="logo" class="rounded mx-2 me-1 img-thumbnail bg-light border-0 d-none d-lg-block" style="height: 50px;"></a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>


                    <div class="collapse navbar-collapse" id="navbarScroll">

                        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">

<!--                            <li class="nav-item">-->
<!--                                <a class="nav-link active" aria-current="page" href="index.php">Home</a>-->
<!--                            </li>-->

<!--                            <li class="nav-item">-->
<!--                                <a class="nav-link" href="#">My Orders</a>-->
<!--                            </li>-->

<!--                            <li class="nav-item dropdown">-->
<!--                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
<!--                                    catergories-->
<!--                                </a>-->
<!--                                <ul class="dropdown-menu">-->
<!--                                    <li><a class="dropdown-item" href="#computer">Computers</a></li>-->
<!--                                    <li><a class="dropdown-item" href="#laptop">Laptops</a></li>-->
<!--                                    <li><a class="dropdown-item" href="#">Audio device</a></li>-->
<!--                                    <li><a class="dropdown-item" href="#">computer accessories</a></li>-->
<!---->
<!--                                </ul>-->
<!--                            </li>-->

                        </ul>

                        <div class="d-flex col-lg-6  col-12" role="search">
                            <div class="input-group mb-3">
<!--                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">All cattogories</button>-->
<!--                                <ul class="dropdown-menu">-->
<!--                                    <li><a class="dropdown-item" href="#">Mobile Phones</a></li>-->
<!--                                    <li><a class="dropdown-item" href="#">Laptops</a></li>-->
<!--                                    <li><a class="dropdown-item" href="#">Computers</a></li>-->
<!--                                    <li><a class="dropdown-item" href="#">computer accessories</a></li>-->
<!--                                </ul>-->
                                <input type="text" class="form-control" placeholder="Search..." id="searchbox" onchange="searchBoxOnchange()" aria-label="Text input with dropdown button" value="<?php echo $keywords ?>">
                                <button class="btn btn-outline-dark"  data-bs-toggle="modal" data-bs-target="#searchWithFilterModel" >Add Filters</button>
                                <button class="btn btn-dark" onclick="searchProductWithFilters()">Search</button>
                            </div>
                        </div>

                        <div class="col-3 d-none d-lg-flex justify-content-end ">

                            <button class="btn btn-light">
                                <a href="<?php echo $isLogin == true ?'user-panel.php':'login.php' ?>" class="text-dark">
                                    <h3 class=" bi bi-person fw-bold  "></h3>
                                </a>

                            </button>
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#WhishListModal"  onclick="<?php echo $isLogin == true ? 'loadWishListsData()' : 'window.location.href = \'login.php\'' ?>">
                                <h3 class=" bi bi-heart text-danger fw-bold  "></h3>
                            </button>
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#cartModal"  onclick="<?php echo $isLogin == true ? 'loadCartData()' : 'window.location.href = \'login.php\'' ?>">
                                <h3 class=" bi bi-bag  fw-bold"></h3>
                            </button>

                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
