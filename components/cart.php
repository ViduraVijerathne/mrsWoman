<!-- Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-xl">
        <div class="modal-content ">

            <div class="container-fluid">
                <div class="row bg-black bg-opacity-10">
                    <div class="col-12 ">
                        <div class="row">
                            <!-- Bag -->
                            <div class="col-lg-7 col-12  bg-light m-3 rounded overflow-hidden" style="height: 750px;">
                                <!-- Header -->
                                <div class="row ">
                                    <div class="col-6 ">
                                        <span class="fw-bold fs-2 pt-5">Shopping Bag</span>
                                    </div>

                                    <div class="col-6 text-end mt-5">
                                        <span class="fs-5" id="CartItemCount">0 Items</span>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                </div>
                                <!-- Header -->

                                <!-- Body -->
                                <div class="row overflow-scroll" style="height: 750px;;">

                                    <div class="col-12 " id="cardItemBody">

                                       




                                        <!-- One cart item -->
<!--                                        <div class="row">-->
<!--                                            <div class="col-5">-->
<!--                                                <img src="../src/images/product_images/1.png" class="img-thumbnail" alt="no" srcset="">-->
<!--                                            </div>-->
<!--                                            <div class="col-7">-->
<!---->
<!--                                                <div class="row">-->
<!---->
<!--                                                    <div class="col-12 fw-bold">Get To It Athletic Wrap Jacket</div>-->
<!--                                                    <div class="col-12">-->
<!--                                                        <hr>-->
<!--                                                    </div>-->
<!--                                                    <div class="col-6 mt-2">-->
<!--                                                        Color: <span class="fw-bold">Brown</span>-->
<!--                                                        <div class="rounded-circle  border ms-1  " style="height: 30px; width: 30px; background-color:#0f0000;"></div>-->
<!---->
<!--                                                    </div>-->
<!--                                                    <div class="col-6 mt-4">-->
<!--                                                        Size: <span class="bg-black fw-bold  text-white p-1 rounded"> M</span>-->
<!--                                                    </div>-->
<!---->
<!--                                                    <div class="col-12">-->
<!--                                                        <hr>-->
<!--                                                    </div>-->
<!---->
<!---->
<!--                                                    <div class="col-lg-6 col-4">-->
<!--                                                        <div class="row">-->
<!--                                                            <input type="number" name="" id="" min="0" class="col-12 mt-3" placeholder="Quentity">-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!---->
<!---->
<!--                                                    <div class="col-8 col-lg-6 mt-3">-->
<!--                                                        <div class="row">-->
<!---->
<!--                                                            <div class="col-3 offset-2">-->
<!--                                                                <button class="btn btn-dark"><i class="bi bi-trash-fill"></i></button>-->
<!---->
<!--                                                            </div>-->
<!---->
<!--                                                            <div class="col-3">-->
<!--                                                                <button class="btn btn-danger"><i class="bi bi-heart-fill"></i></button>-->
<!--                                                            </div>-->
<!---->
<!--                                                            <div class="col-3">-->
<!--                                                                <button class="btn btn-primary"><i class="bi bi-eye-fill "></i></button>-->
<!--                                                            </div>-->
<!---->
<!---->
<!---->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!---->
<!--                                                    <div class="col-12">-->
<!--                                                        <div class="row">-->
<!--                                                            <div class="col-6">-->
<!---->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!---->
<!---->
<!---->
<!--                                                </div>-->
<!---->
<!---->
<!---->
<!---->
<!---->
<!--                                            </div>-->
<!---->
<!--                                            <div class="col-12">-->
<!--                                                <hr>-->
<!--                                            </div>-->
<!---->
<!---->
<!--                                        </div>-->



                                       


                                    </div>
                                    <div style="height: 200px"></div>
                                </div>
                            </div>

                            <!-- Summery -->
                            <div class="col-lg-4 col-12 bg-light m-3 rounded">
                                <div class="row">
                                    <span class="fw-bold text-capitalize fs-3">summary</span>
                                </div>

                                <div class="row">
                                    <hr>
                                </div>

                                <div class="row" id="summeryBody">
                                    <div class="col-12">
                                        <div class="row fw-bold fs-4 mt-5">
                                            <div class="col-3 fs-5">
                                                Products
                                            </div>
                                            <div class="col-6 fs-5" id="cartProductCount">

                                            </div>
                                        </div>

                                        <div class="row fw-bold fs-4  d-none">
                                            <div class="col-3 fs-5">
                                                Items
                                            </div>
                                            <div class="col-6 fs-5" id="cartItemCount">
                                                :0
                                            </div>
                                        </div>

                                        <div class="row">
                                            <hr class=" mt-3">
                                        </div>

                                        <div class="row fw-bold fs-4">
                                            <div class="col-2 fs-5">
                                                Ship To
                                            </div>
                                            <div class="col-9 ">
                                                <textarea rows="10" type="text" class="form-control" id="cartShippingAddress"></textarea>

                                            </div>
                                            <div class="col-1">
                                                <button class="btn btn-dark "><i class="bi bi-pencil-square"></i></button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <hr class=" mt-3">
                                        </div>



                                        <div class="row fw-bold fs-4">
                                            <div class="col-3 fs-5">
                                                Subtotal
                                            </div>
                                            <div class="col-6 fs-5" id="cartSubTotal">
                                                :25$
                                            </div>
                                        </div>

                                        <div class="row fw-bold fs-4">
                                            <div class="col-3 fs-5">
                                                Shipping
                                            </div>
                                            <div class="col-6 fs-5" id="cartshippingTotal">
                                                :25$
                                            </div>
                                        </div>

                                        <div class="row">
                                            <hr class=" mt-3">
                                        </div>

                                        <div class="row fw-bold fs-4">
                                            <div class="col-6 fs-5">
                                                Grand Total
                                            </div>
                                            <div class="col-6 fs-5" id="cartGrandTotal">
                                                : 25$
                                            </div>
                                        </div>

                                        <div class="row">
                                            <hr class=" mt-3">
                                        </div>
                                        <div class="row">
                                            <hr class=" mt-3">
                                        </div>

                                        <div class="row">

                                            <button class="btn btn-dark d-grid col-6 offset-3" onclick="checkOut()">CheckOut</button>

                                        </div>





                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
</div>