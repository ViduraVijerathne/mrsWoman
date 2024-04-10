<?php
global $APP_NAME;
require_once "const/AppStrings.php";
$PAGE_NAME = "Login";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title><?php echo   $PAGE_NAME?> : <?php echo  $APP_NAME?></title>

</head>

<body>
<div class="container-fluid">
    <div class="row  overflow-hidden" style="height:100vh;">
        <div class="col-12  ">
            <div class="row">
                <div class="d-none col-lg-6 d-lg-block d-none">
                    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="src/images/login_corosol/image_6cf6e26b-aa37-4b5a-8429-58ed07e16fc0_540x.webp" class="d-block w-100 img-thumbnail" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="src/images/login_corosol/image_863b9846-bce1-4ca5-bef4-69be307fa0f0_540x.webp" class="d-block w-100 img-thumbnail" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="src/images/login_corosol/image_a326e49b-fd88-413b-9751-b6744f15b4ee_540x.webp" class="d-block w-100 img-thumbnail" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <!-- Sign in -->
                <div class="col-12 col-lg-6 mt-5  " id="signin">
                    <div class="row mt-5">
                        <div class="col-4 offset-4">
                            <img src="src/logo.png" class="img-fluid" alt="" srcset="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="fw-bold fs-5  text-capitalize text-black-50 ">Hello Buetifull..! Welcome Back! </span>
                        </div>
                    </div>



                    <div class="row mt-5">
                        <div class="col-12 col-lg-6 offset-lg-3">
                            <input type="text" placeholder="Email" class="form-control" id="e2" value="">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-lg-6 offset-lg-3">
                            <input type="password" placeholder="Password" class="form-control" id="p2" value="">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-lg-8 offset-lg-2">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember Me!</label>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-lg-4 offset-lg-4 d-grid">
                            <button class="btn btn-dark fw-bold" onclick="signin()">Sign in</button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">

                        </div>
                    </div>

                    <div class="row mt-4 text-center " style="cursor:pointer;">
                        <div class="col-12 text-center">
                            <span class="text-capitalize fw-bold border border-dark p-2 " onclick="hideViewComponent('signin','signup')">don't have already account? <span>Sign up</span></span>
                        </div>


                    </div>



                    <div class="row mt-2 " style="cursor:pointer;">
                        <div class="col-12 text-center">
                            <span class="fw-bold">OR</span>
                        </div>

                        <div class="col-12 text-center mt-2">
                            <span class="text-capitalize fw-bold" onclick="hideViewComponent('signin','frogot')">Frogot Password? Recover Passwords </span>
                        </div>

                    </div>

                </div>


                <!-- Sign Up -->
                <div class="col-12 col-lg-6 mt-5" id="signup">
                    <div class="row mt-5">
                        <div class="col-4 offset-4">
                            <img src="../../src/logo.png" class="img-fluid" alt="" srcset="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="fw-bold fs-5  text-capitalize text-black-50 ">Hello Buetifull..! Welcome Back! </span>
                        </div>
                    </div>



                    <div class="row mt-5">
                        <div class="col-12 col-lg-6 offset-lg-3">
                            <input type="text" placeholder="Full Name" class="form-control" id="name">
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-12 col-lg-6 offset-lg-3">
                            <input type="text" placeholder="Mobile" class="form-control" id="m">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-lg-6 offset-lg-3">
                            <input type="text" placeholder="Email" class="form-control" id="e">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-lg-6 offset-lg-3">
                            <input type="password" placeholder="Password" class="form-control" id="p">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-lg-6 offset-lg-3">
                            <input type="password" placeholder="Retype Password" class="form-control" id="pretype">
                        </div>
                    </div>



                    <div class="row mt-3">
                        <div class="col-12 col-lg-4 offset-lg-4 d-grid">
                            <button class="btn btn-dark fw-bold" onclick="signupUser()">Sign up</button>
                        </div>
                    </div>



                    <div class="row mt-4 text-center " style="cursor:pointer;" onclick="hideViewComponent('signup','signin')">
                        <div class="col-12 text-center">
                            <span class="text-capitalize fw-bold border border-dark p-2 ">already have account? <span>Sign in</span></span>
                        </div>


                    </div>





                </div>

                <!-- fogot -->
                <div class="col-12 col-lg-6 mt-5 d-none" id="frogot">
                    <div class="row mt-5">
                        <div class="col-4 offset-4">
                            <img src="../../src/logo.png" class="img-fluid" alt="" srcset="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="fw-bold fs-5  text-capitalize text-black-50 ">Hello Buetifull..! Welcome Back! Recover Your Password </span>
                        </div>
                    </div>

                    <div class="row d-none" id="spinner_signin">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="spinner-border text-center" role="status">
                                <span class="visually-hidden">Loading...</span>

                            </div>
                        </div>
                    </div>


                    <div class="row mt-5">
                        <div class="col-12 col-lg-6 offset-lg-3" id="EmailInput">
                            <input type="text" placeholder="Email" class="form-control" id="e3" value="">
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12 col-lg-6 offset-lg-3 d-none" id="npContainer">
                            <input type="text" placeholder="New Password" class="form-control" id="np">
                        </div>
                    </div>

<!--                    <div class="row mt-3 d-none" id="verificationInput">-->
<!--                        <div class="col-12 col-lg-6 offset-lg-3">-->
<!--                            <input type="text" placeholder="Verification Code" class="form-control" id="verificationCode" value="">-->
<!--                        </div>-->
<!--                    </div>-->


                    <div class="row mt-3 d-none" id="cpasswordContainer">
                        <div class="col-12 col-lg-4 offset-lg-4 d-grid">
                            <button class="btn btn-dark fw-bold" onclick="changeRecoverPassword()">Change Password</button>
                        </div>
                    </div>



                    <div class="row mt-3 d-none" id="recoverID">
                        <div class="col-12 col-lg-4 offset-lg-4 d-grid">
                            <button class="btn btn-dark fw-bold" onclick="verifyUserEmailCode()">Recover</button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 col-lg-4 offset-lg-4 d-grid" id="sendEmail">
                            <button class="btn btn-dark fw-bold" onclick="sendVerificationEmail()">Send Verification Email</button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">

                        </div>
                    </div>

                    <div class="row mt-4 text-center " style="cursor:pointer;">
                        <div class="col-12 text-center">
                            <span class="text-capitalize fw-bold border border-dark p-2 " onclick="hideViewComponent('signin','signup')">don't have already account? <span>Sign up</span></span>
                        </div>


                    </div>





                </div>

<!--                VC-->
                <div class="col-12 col-lg-6 mt-5 d-none" id="VCcontainer">
                    <div class="row mt-5">
                        <div class="col-4 offset-4">
                            <img src="../../src/logo.png" class="img-fluid" alt="" srcset="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="fw-bold fs-5  text-capitalize text-black-50 ">Hello Buetifull..! Welcome Back! Recover Your Password </span>
                        </div>
                    </div>

                    <div class="row d-none  mt-5" id="spinner_VC">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="spinner-border text-center" role="status">
                                <span class="visually-hidden">Loading...</span>

                            </div>
                        </div>
                    </div>


                    <div class="row mt-3 " id="verificationInput">
                        <div class="col-12 col-lg-6 offset-lg-3">
                            <input type="text" placeholder="Verification Code" class="form-control" id="verificationCode" value="">
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-12 col-lg-4 offset-lg-4 d-grid" id="">
                            <button class="btn btn-dark fw-bold" onclick="vcUser()">Verify </button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">

                        </div>
                    </div>

                    <div class="row mt-4 text-center " style="cursor:pointer;">
                        <div class="col-12 text-center">
                            <span class="text-capitalize fw-bold border border-dark p-2 " onclick="hideViewComponent('signin','signup')">don't have already account? <span>Sign up</span></span>
                        </div>


                    </div>





                </div>


            </div>

        </div>

    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="ErrorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="rounded me-2" class="bi bi-exclamation-triangle-fill"></i>
            <strong class="me-auto text-danger" id="ErrorToast_header">Bootstrap</strong>
            <small id="ErrorToast_time">1 sec ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-danger" id="ErrorToast_body">
            Hello, world! This is a toast message.
        </div>
    </div>
</div>


<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="Toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="rounded me-2" class="bi bi-exclamation-triangle-fill"></i>
            <strong class="me-auto text-success" id="Toast_header">Bootstrap</strong>
            <small id="Toast_time">1 sec ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-success" id="Toast_body">
            Hello, world! This is a toast message.
        </div>
    </div>
</div>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

<!-- MyJs -->
<?php

require_once  'components/whishList.php';
?>
</body>

</html>