<?php
global $APP_NAME;
require_once "const/AppStrings.php";
require_once "const/auth.php";
$PAGE_NAME = "ADMIN-PANEL";
$adminName = "";
session_start();
if(isUser()){
if(isset($_SESSION['user_email'])){
    $adminName = $_SESSION['user_name'];
}

?>
<!DOCTYPE html>
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
    <script src="js/dashboard.js"></script>
    <script src="js/userPanel.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- Include Chart.js from a CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title><?php echo $PAGE_NAME . " " . $APP_NAME ?></title>
</head>

<body class="overflow-hidden" onload="navigationAdminPanel('10')">
<!--<body class="overflow-hidden">-->

<div class="container-fluid">
    <div class="row">
        <!-- Left  Buttons -->
        <div class="col-2 bg-light overflow-scroll border-end" style="height:100vh;">
            <!-- Logo -->
            <div class="col-12 mt-5">
                <img src="src/logo.png" class="img-fluid" alt="logo" srcset="">
            </div>

            <div class="col-12 mt-3"></div>

            <button class="col-12 btn btn-dark fw-bold text-start" onclick="navigationAdminPanel('10')" id="navBtn_10"><i
                        class="bi bi-window-desktop"></i>&nbsp; Active Orders
            </button>
            <button class="col-12 btn mt-1 btn-light fw-bold text-start" onclick="navigationAdminPanel('11')"
                    id="navBtn_11"><i class="bi bi-tags-fill"></i>&nbsp; Completed Orders
            </button>
            <button class="col-12 btn mt-1 btn-light fw-bold text-start" onclick="navigationAdminPanel('12')"
                    id="navBtn_12"><i class="bi bi-patch-plus"></i>&nbsp; Address Book
            </button>
            <!--            <button class="col-12 btn mt-1 btn-light fw-bold text-start" onclick="navigationAdminPanel('6')"-->
            <!--                    id="navBtn_6"><i class="bi bi-chat-dots-fill"></i>&nbsp; Messages-->
            <!--            </button>-->
            <button class="col-12 btn mt-1 btn-light fw-bold text-start" onclick="navigationAdminPanel('13')"
                    id="navBtn_13"><i class="bi bi-door-open-fill"></i>&nbsp; Log Out
            </button>


        </div>


        <!-- Center Side -->
        <div class="col-10 h-25">

            <!-- Header -->
            <div class="row ms-1 bg-light pb-1 border-bottom">
                <div class="col-6">
                    <div class="row">
                        <div class="col-12 fw-bold fs-3 text-capitalize">Hello <span class=""><?php echo  $adminName?></span> !</div>
                    </div>
                    <div class="row fw-bold text-black-50">Let's Do Something new Day !</div>
                </div>
                <div class="col-6 mt-3">
                    <div class="row">
                        <div class="col-10">
                            <input type="text" name="" id="" class="form-control ">
                        </div>

                        <div class="col-2">
                            <button class="btn btn-outline-dark"><i class="bi bi-bell-fill"></i></button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Center Body -->
            <div class="row bg-light">
                <div class="col-12 overflow-scroll " style="height:90vh;" id="adminCenter">

                </div>
            </div>


        </div>


    </div>

</div>


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>

<!-- MyJs -->
<!--<script src="../../js/script_style.js"></script>-->
<!--<script src="../../js/script_com.js"></script>-->

<!-- chartJS -->

<?php
}else{
//    redirect to login.php
    header("Location:./login.php");
}
require './components/Toasts.php';
?>
</body>


</html>