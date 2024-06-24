const ViewProductDescribeView = (pid) => {
    const productMainCard = document.getElementById("productMainCard_" + pid);
    const productQuickViewCard = document.getElementById("productQuickViewCard_" + pid);
    const productDescribeViewCard = document.getElementById("productDescribeViewCard_" + pid);
//
// //     set product card width 12
//     productMainCard.classList.remove("col-lg-3");
//     productMainCard.classList.add("col-lg-12");
//
//     //hide quick view
//     productQuickViewCard.classList.add("d-none");
//
//     //view describeView
//     productDescribeViewCard.classList.remove("d-none");

    // Hide quick view with animation
    productQuickViewCard.style.transition = "opacity 0.5s ease-out";
    productQuickViewCard.style.opacity = "0";
    productQuickViewCard.style.pointerEvents = "none"; // Disable pointer events during animation

    // Show describe view with animation
    productDescribeViewCard.style.transition = "opacity 0.5s ease-in";
    productDescribeViewCard.style.opacity = "1";
    productDescribeViewCard.style.pointerEvents = "auto"; // Re-enable pointer events after animation

    // Delay hiding quick view and showing describe view until animation is complete
    setTimeout(() => {
        productQuickViewCard.classList.add("d-none");
        productMainCard.classList.remove("col-lg-3");
        productMainCard.classList.add("col-lg-12");
        productDescribeViewCard.classList.remove("d-none");
    }, 500); // 500 milliseconds is the duration of the animation

    // document.getElementById("body").scrollTo({"behavior":"smooth",top:5000})


}

const ViewProductQuickView = (pid) => {
    const productMainCard = document.getElementById("productMainCard_" + pid);
    const productQuickViewCard = document.getElementById("productQuickViewCard_" + pid);
    const productDescribeViewCard = document.getElementById("productDescribeViewCard_" + pid);

// //     set product card width 12
//     productMainCard.classList.remove("col-lg-12");
//     productMainCard.classList.add("col-lg-3");
//
//     //view quick view
//     productQuickViewCard.classList.remove("d-none");
//
//     //hide describeView
//     productDescribeViewCard.classList.add("d-none");


    // Hide describe view with animation
    productDescribeViewCard.style.transition = "opacity 0.5s ease-out";
    productDescribeViewCard.style.opacity = "0";
    productDescribeViewCard.style.pointerEvents = "none"; // Disable pointer events during animation

    // Show quick view with animation
    productQuickViewCard.style.transition = "opacity 0.5s ease-out";
    productQuickViewCard.style.opacity = "1";
    productQuickViewCard.style.pointerEvents = "auto"; // Re-enable pointer events after animation

    // Delay hiding describe view and showing quick view until animation is complete
    setTimeout(() => {
        productDescribeViewCard.classList.add("d-none");
        productMainCard.classList.remove("col-lg-12");
        productMainCard.classList.add("col-lg-3");
        productQuickViewCard.classList.remove("d-none");
    }, 500); // 500 milliseconds is the duration of the animation


}

const hideViewComponent = (hide, view) => {
    document.getElementById(hide).classList.add('d-none');
    document.getElementById(view).classList.remove('d-none')

}


const adminPanelList = {
    0: {
        name: "Dashboard",
        process: "pages/admin-dashboard.php"
    },
    1: {
        name: "Products",
        process: "pages/admin-products.php"
    },
    2: {
        name: "Active Orders",
        process: "pages/active-orders.php"
    },
    3: {
        name: "Delivered Products",
        process: "pages/delivered-products.php"
    },
    4: {
        name: "Invoices",
        process: "pages/invoices.php"
    },
    5: {
        name: "Customers",
        process: "pages/customers.php"
    },
    6: {
        name: "Messages",
        process: "pages/messages.php"
    },
    7: {
        name: "Log Out",
        process: "pages/admin-logout.php"
    },
    8: {
        name: "Add Product",
        process: "pages/add-product.php"
    },
    10:{
        name: "User-panel Active Orders",
        process: "pages/user-panel-active-orders.php"
    },
    11:{
        name: "User-panel Complete Orders",
        process: "pages/user-panel-complete-orders.php"
    },
    12:{
        name: "User-panel AddressBook",
        process: "pages/user-panel-addressBook.php"
    },
    13:{
        name: "User-panel AddressBook",
        process: "pages/user-logout.php"
    }
};

const showErrorToast = (title, body) => {
    document.getElementById("ErrorToast_header").innerText = title;
    document.getElementById('ErrorToast_body').innerText = body;
    const toast = new bootstrap.Toast(document.getElementById('ErrorToast'));
    toast.show();
}
const showSuccessToast = (title, body) => {
    document.getElementById("Toast_header").innerText = title;
    document.getElementById('Toast_body').innerText = body;
    const toast = new bootstrap.Toast(document.getElementById('Toast'));
    toast.show();
}
const showAdminPanelLoadingSpinner = () => {
    document.getElementById("adminCenter").innerHTML = "<div class='spinner'> </div>"
}
function updatePanelID(newPanelID) {
    // Get the current URL
    const url = new URL(window.location.href);

    // Update the panelID parameter
    url.searchParams.set('panelID', newPanelID);

    // Use history.pushState to update the URL without refreshing
    window.history.pushState({}, '', url);
}
const loadAdminPages = (id) => {

    const request = new XMLHttpRequest();
    request.open("GET", adminPanelList[id].process, true)
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            console.log(request.responseText);
            const responseObj = JSON.parse(request.responseText);
            console.log(responseObj)
            if (responseObj.statusCode === 1) {
                updatePanelID(id)
                document.getElementById("adminCenter").innerHTML = responseObj.body;

                if(id == 0){
                    loadDashboardChart()
                }
            } else {
                showErrorToast(adminPanelList[id].name + " ERROR", responseObj.message);
            }

            if (id == 7 || id == 13) {
                location.reload();
            }
        }
    }
    request.send()


}


var selectedNavBtnID = "0"
const navigationAdminPanel = (panelID) => {
    showAdminPanelLoadingSpinner();
    const requested_navBtn = document.getElementById("navBtn_" + panelID);
    const oldSelected_navBtn = document.getElementById("navBtn_" + selectedNavBtnID);

    oldSelected_navBtn.classList.remove("btn-dark")
    oldSelected_navBtn.classList.add("btn-light")

    requested_navBtn.classList.add("btn-dark")
    requested_navBtn.classList.remove("btn-light")

    selectedNavBtnID = panelID;

    loadAdminPages(panelID);


}

const selectedProductImages = [];

const loadAdminAddProductImageCarosal = () => {
    const carosalIndecatorPrefix = "<div class=\"carousel-indicators\">";
    const carosalIndecatorSuffix = "</div>";
    let carosalIndecator = "";

    const carouseLinerPrefix = "<div class=\"carousel-inner\">";
    const carouseLinerSufix = "</div>";
    let carouseLiner = "";

    const btn = "<button class=\"carousel-control-prev\" type=\"button\" data-bs-target=\"#carouselExampleControls\" data-bs-slide=\"prev\">\n" +
        "                                            <span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>\n" +
        "                                            <span class=\"visually-hidden\">Previous</span>\n" +
        "                                        </button>\n" +
        "                                        <button class=\"carousel-control-next\" type=\"button\" data-bs-target=\"#carouselExampleControls\" data-bs-slide=\"next\">\n" +
        "                                            <span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>\n" +
        "                                            <span class=\"visually-hidden\">Next</span>\n" +
        "                                        </button>";

    for (let i = 0; i < selectedProductImages.length; i++) {
        if (i === 0) {
            carosalIndecator = "<button type=\"button\" data-bs-target=\"#carouselExampleCaptions\" data-bs-slide-to=\"0\" class=\"active\" aria-current=\"true\" aria-label=\"Slide 1\"></button>";
        } else {
            carosalIndecator += "<button type=\"button\" data-bs-target=\"#carouselExampleCaptions\" data-bs-slide-to='" + i + "' aria-label=\"Slide " + (i++) + "\"></button>";
        }

        carouseLiner += "<div class=\"carousel-item active\" data-bs-interval=\"3000\">\n" +
            "                                                <img src='" + URL.createObjectURL(selectedProductImages[i]) + "' class=\"d-block w-100\" alt=\"...\">\n" +
            "                                            </div>";


    }


    const element = carosalIndecatorPrefix + carosalIndecator + carosalIndecatorSuffix + carouseLinerPrefix + carouseLiner + carouseLinerSufix + btn;
    document.getElementById("carouselExampleControls").innerHTML = element;

}
const removeAdminAddProductImage = (fileName) => {
    for (let i = 0; i < selectedProductImages.length; i++) {
        const name = selectedProductImages[i].name;
        console.log("filePath : " + fileName + " ; path : " + name)
        if (fileName === name) {
            selectedProductImages.splice(i, 1); // Remove the element at index i

            break; // Exit the loop after removing the element
        }
    }


    loadAdminAddProductImageComponent();


}
const loadAdminAddProductImageComponent = () => {
    const container = document.getElementById("adminAddProductImageListComponentContainer");
    container.innerHTML = "";
    for (let i = 0; i < selectedProductImages.length; i++) {
        const filename = selectedProductImages[i].name;
        const path = URL.createObjectURL(selectedProductImages[i]);
        const id = "'" + filename + "'"

        const com = ' <div class="col-12">\n' +
            '                                    <div class="row m-1 p-1 bg-black rounded-2 text-light">\n' +
            '                                        <div class="col-3">\n' +
            '                                            <img src="' + path + '" style="height: 100px" class="img-fluid" alt="">\n' +
            '                                        </div>\n' +
            '                                        <div class="col-7 text-break fw-lighter">\n' +
            '                                           ' + filename +
            '                                        </div>\n' +
            '                                        <div class="col-1 d-flex justify-content-center align-items-center">\n' +
            '                                            <button onclick="removeAdminAddProductImage(' + id + ')" class="btn-danger btn">\n' +
            '                                                <i class="bi bi-trash-fill"></i>\n' +
            '                                            </button>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                </div>'

        container.innerHTML += com;

    }
    loadAdminAddProductImageCarosal()
}
const loadAdminAddProductImageList = () => {
    const fileInput = document.getElementById("productImages_uploader");
    const files = fileInput.files;
    if (files.length > 3) {
        showErrorToast("OOPS!", "You can choose only 3 images")
        return;
    }

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const fileName = file.name;
        const fileExtension = fileName.split('.').pop().toLowerCase();

        if (fileExtension !== 'png' && fileExtension !== 'jpg' && fileExtension !== 'webp') {
            showErrorToast("file type Error", `File ${fileName} is not a valid type. Only PNG, JPG, and WEBP files are allowed.`);
            return; // Stop further processing if an invalid file is found
        }


    }

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        selectedProductImages.push(file);
    }

    loadAdminAddProductImageComponent();


}

const AddProductStock = [];


const removeAdminPRoductStock = (stockListID) => {
    for (let i = 0; i < AddProductStock.length; i++) {
        const stock = AddProductStock[i];
        console.log(stock.id + " " + stockListID);
        console.log(stock.id == stockListID)
        if (stock.id == stockListID) {
            AddProductStock.splice(i, 1);
            break;
        }
    }
    loadAdminAddProductStockComponent();

}

const loadAdminAddProductStockComponent = () => {
    document.getElementById("AdminAddProductStockListContainer").innerHTML = "";
    for (let i = 0; i < AddProductStock.length; i++) {
        const stock = AddProductStock[i];
        const size = stock.size;
        const colorCode = stock.colorCode;
        const colorName = stock.colorName;
        const qty = stock.qty;
        const price = stock.price;
        const delivery = stock.delivery;
        const id = "'" + stock.id + "'";
        const com = '<div class="col-12 border border-dark border-1 rounded p-1 m-1 " id = "stockItem_' + id + '">\n' +
            '                            <div class="row">\n' +
            '                                <div class="col-2 text-center fw-bold d-flex justify-content-center align-items-center">\n' +
            '                                    ' + size + '\n' +
            '                                </div>\n' +
            '                                <div class="col-2 text-center fw-bold d-flex justify-content-center align-items-center">\n' +
            '                                    <div class="rounded-circle" style="width: 50px;height: 50px;background-color: ' + colorCode + '"></div>\n' +
            '                                </div>\n' +
            '                                <div class="col-2 text-center text-uppercase fw-bold d-flex justify-content-center align-items-center">\n' +
            '                                    ' + colorName + '\n' +
            '                                </div>\n' +
            '                                <div class="col-2 text-center text-uppercase fw-bold d-flex justify-content-center align-items-center">\n' +
            '                                    x' + qty + '\n' +
            '                                </div>\n' +
            '                                <div class="col-1 text-center text-uppercase fw-bold d-flex justify-content-center align-items-center">\n' +
            '                                    $' + price + '\n' +
            '                                </div>\n' +
            '                                <div class="col-1 text-center  d-flex text-uppercase fw-bold justify-content-center align-items-center">\n' +
            '                                    $' + delivery + '\n' +
            '                                </div>\n' +
            '                                <div class="col-1 text-center  d-flex text-uppercase fw-bold justify-content-center align-items-center">\n' +
            '                                    <button onclick="removeAdminPRoductStock(' + id + ')" class="btn-danger btn">\n' +
            '                                        <i class="bi bi-trash-fill"></i>\n' +
            '                                    </button>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>'


        document.getElementById("AdminAddProductStockListContainer").innerHTML += com;
    }
}

const addNewProductStock = () => {
    const sizeID = document.getElementById("AddProductSize").value
    const size = document.getElementById("AddProductSize").options[sizeID].text
    const colorCode = document.getElementById("AddProductColor").value
    const colorName = document.getElementById("addProductColorName").value
    const qty = document.getElementById("addProductQty").value
    const price = document.getElementById("addProductPrice").value
    const delivery = document.getElementById("addProductDeliveryFree").value
    const id = Math.random()
    console.log(size + ":" + sizeID)
    console.log(document.getElementById("AddProductSize").options);

//     validation
    if (size === "" || colorCode === "" || colorName === "" || qty === "" || price === "" || delivery === "") {
        showErrorToast("OOPS!", "Please fill all the fields")
        return;
    }
    if (sizeID == 0) {
        showErrorToast("OOPS!", "Please select a size")
        return;
    }

    const productStock = {
        id: id,
        size: size,
        sizeID: sizeID,
        colorCode: colorCode,
        colorName: colorName,
        qty: qty,
        price: price,
        delivery: delivery
    }

    AddProductStock.push(productStock);

    //clear input fields
    document.getElementById("AddProductSize").value = "";
    document.getElementById("AddProductColor").value = "#000000";
    document.getElementById("addProductColorName").value = "";
    document.getElementById("addProductQty").value = "";
    document.getElementById("addProductPrice").value = "";
    document.getElementById("addProductDeliveryFree").value = "";

    loadAdminAddProductStockComponent();


}

const adminAddNewProduct = () => {
    const productName = document.getElementById("productName").value;
    const productDescription = document.getElementById("productDescription").value;
    const productImages = document.getElementById("productImages_uploader").files;
    const category = document.getElementById("catergoryOption").value;

//     validate product name is not empty string and product name max length is 100
    if (productName === "" || productName.length > 100) {
        showErrorToast("OOPS!", "Please fill all the fields")
        return;
    }
//     validate product description is not empty and max length is 500
    if (productDescription === "" || productDescription.length > 500) {
        showErrorToast("OOPS!", "Please fill all the fields")
        return;
    }

    //validate product image is extention jpg or png webp files and files max length is 3
    if (productImages.length > 3) {
        showErrorToast("OOPS!", "You can choose only 3 images")
        return;
    }


    //validate AddProductStock length is not empty
    if (AddProductStock.length === 0) {
        showErrorToast("OOPS!", "Please fill all the fields")
        return;
    }

//     XMLHTTP request to process/addProductProcess.php with POST parameters form data

    const form = new FormData();
    form.append("productName", productName);
    form.append("productDescription", productDescription);
    form.append("category", category);

    for (let i = 0; i < productImages.length; i++) {
        // alert(i);
        form.append("productImages[]", productImages[i]);
    }
    form.append("AddProductStock", JSON.stringify(AddProductStock));


    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            // console.log(this.responseText);

            const response = JSON.parse(this.responseText);
            console.log(response);
            if (response.statusCode === 1) {
                showSuccessToast(response.message);
                loadAdminPages("8");

                // window.location.href = "adminAddNewProduct.php";
            } else {
                showErrorToast(response.message);
            }
        }
    };
    xhttp.open("POST", "process/addProductProcess.php", true);
    xhttp.send(form);


}

const activateDeactivateProduct = (id, acStatus) => {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            // console.log(this.responseText);

            const response = JSON.parse(this.responseText);
            console.log(response);
            if (response.statusCode === 1) {
                showSuccessToast("Success!", response.message);
                const btn = document.getElementById("productActions_" + id);
                if (acStatus === 1) {
                    btn.onclick = () => {
                        activateDeactivateProduct(id, 0);
                    }
                    btn.classList.add('btn-danger');
                    btn.classList.remove('btn-primary');
                    btn.innerHTML = "Deactivate";

                } else {
                    btn.onclick = () => {
                        activateDeactivateProduct(id, 1);
                    }
                    btn.classList.remove('btn-danger');
                    btn.classList.add('btn-primary');
                    btn.innerHTML = "Activate";

                }
                // loadAdminPages("8");

                // window.location.href = "adminAddNewProduct.php";
            } else {
                showErrorToast("OOPS!", response.message);
            }
        }
    };
    xhttp.open("GET", "process/activeDeactiveProduct.php?pid=" + id + "&status=" + acStatus, true);

    xhttp.send();
}


const selectedProductSizeBtnData = {
    "productID": "sizeBtnID",
}

const SELECTEDPRODUCTSIZECOLOR = {
    "productID": {
        "sizeID": "id",
        "colorID": "id",
    }
}
const SelecteProductChangeSize = (productID, sizeID) => {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            const responseObject = JSON.parse(this.responseText);
            if (responseObject.statusCode === 1) {

                //change btn color
                const SizeBtnID = "size_" + productID + "_" + sizeID;
                const activeBtn = document.getElementById(SizeBtnID);
                activeBtn.classList.add('btn-dark');
                activeBtn.classList.remove('btn-outline-dark');

                const beforeID = selectedProductSizeBtnData[productID];
                if (beforeID != null) {
                    const beforeSizeBtn = document.getElementById(beforeID);
                    beforeSizeBtn.classList.remove('btn-dark');
                    beforeSizeBtn.classList.add('btn-outline-dark');

                }
                selectedProductSizeBtnData[productID] = SizeBtnID;

                const PRODUCTSIZEANDCOLOR = {};
                PRODUCTSIZEANDCOLOR['size'] = sizeID;

                //     render colors

                const stocks = responseObject.stocks;
                const colorContainer = document.getElementById('productColorButtonGroup_' + productID);
                colorContainer.innerHTML = "";
                for (let i = 0; i < stocks.length; i++) {
                    const stock = stocks[i];
                    const colorDiv = document.createElement("div");
                    colorDiv.id = 'colorBtn_' + stock.productID + '_' + stock.colorID;
                    colorDiv.onclick = () => {
                        SelectedProductChangeColor(stock.productID, stock.colorID);
                    }
                    colorDiv.classList.add('rounded-circle');
                    colorDiv.classList.add('border');
                    colorDiv.classList.add('ms-1');
                    colorDiv.classList.add('border-5');
                    colorDiv.style.backgroundColor = stock.colorHex;
                    if (i === 0) {
                        colorDiv.classList.add('active-color-circle');
                        document.getElementById('colorName_' + productID).innerText = stock.colorName;
                        document.getElementById('qty_label_' + productID).innerText = stock.qty;
                        document.getElementById('priceTag_' + productID).innerText = "$ " + stock.price;
                        document.getElementById('shippingCostTag_' + productID).innerText = "$ " + stock.shipping;
                        PRODUCTSIZEANDCOLOR['color'] = stock.colorID
                        PRODUCTSIZEANDCOLOR['price'] = stock.price
                        PRODUCTSIZEANDCOLOR['qty'] = stock.qty
                        PRODUCTSIZEANDCOLOR['ship'] = stock.shipping
                    } else {
                        colorDiv.classList.add('de-active-color-circle');
                    }
                    colorContainer.appendChild(colorDiv);

                }

                SELECTEDPRODUCTSIZECOLOR[productID] = PRODUCTSIZEANDCOLOR;


            } else {
                showErrorToast("oops! Something went wrong", responseObject.message);
            }
        }
    }
    xhttp.open("GET", "process/getProductColorsBySize.php?pid=" + productID + "&sizeID=" + sizeID, true);

    xhttp.send();
}
const SelectedProductChangeColor = (productID, colorID) => {

    console.log(SELECTEDPRODUCTSIZECOLOR[productID]);
    const PRODUCTSIZEANDCOLOR = SELECTEDPRODUCTSIZECOLOR[productID];
    const beforeSelectedColorID = PRODUCTSIZEANDCOLOR['color'];
    PRODUCTSIZEANDCOLOR['color'] = colorID;
    SELECTEDPRODUCTSIZECOLOR[productID];
    console.log(SELECTEDPRODUCTSIZECOLOR[productID]);
    if (beforeSelectedColorID != undefined && beforeSelectedColorID != null) {
        const beforeColorBtn = document.getElementById('colorBtn_' + productID + '_' + beforeSelectedColorID);
        beforeColorBtn.classList.remove('active-color-circle');
        beforeColorBtn.classList.add('de-active-color-circle');
    }

    const selectedColorBtn = document.getElementById('colorBtn_' + productID + '_' + colorID);
    selectedColorBtn.classList.remove('de-active-color-circle');
    selectedColorBtn.classList.add('active-color-circle');

    document.getElementById('qty_label_' + productID).innerText = PRODUCTSIZEANDCOLOR['qty'];
    document.getElementById('priceTag_' + productID).innerText = "$ " + PRODUCTSIZEANDCOLOR['price'];
    document.getElementById('shippingCostTag_' + productID).innerText = "$ " + PRODUCTSIZEANDCOLOR['ship']

}


const signupUser = () => {
    const name = document.getElementById("name").value;
    const email = document.getElementById("e").value;
    const mobile = document.getElementById("m").value;
    const password = document.getElementById("p").value;
    const retypePassword = document.getElementById("pretype").value;

    const form = new FormData();
    form.append('name', name);
    form.append('email', email);
    form.append('mobile', mobile);
    form.append('password', password);
    form.append('retypePassword', retypePassword);

    const xmlHTTPRequest = new XMLHttpRequest();
    xmlHTTPRequest.onreadystatechange = function () {
        if (xmlHTTPRequest.readyState === 4 && xmlHTTPRequest.status === 200) {
            const obj = JSON.parse(xmlHTTPRequest.responseText);
            if (obj.statusCode === 1) {
                showSuccessToast('Success!', obj.message);
                hideViewComponent('signup', 'VCcontainer')
            } else {
                showErrorToast('oops!', obj.message);

            }
        }
    }


    xmlHTTPRequest.open('POST', 'process/login-user.php', true)
    xmlHTTPRequest.send(form);
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

const vcUser = () => {
    const vc = document.getElementById('verificationCode').value;
    document.getElementById('spinner_VC').classList.remove('d-none');
    const form = new FormData();
    form.append('vc', vc);

    const xmlHttpRequest = new XMLHttpRequest();
    xmlHttpRequest.onreadystatechange = async function () {
        if (xmlHttpRequest.readyState === 4 && xmlHttpRequest.status === 200) {
            const obj = JSON.parse(xmlHttpRequest.responseText);
            if (obj.statusCode === 1) {
                showSuccessToast('Success!', obj.message);
                await sleep(2000);
                document.getElementById('spinner_VC').classList.add('d-none');

                window.location.reload();
            } else {
                await sleep(2000);

                document.getElementById('spinner_VC').classList.add('d-none');
                showErrorToast('oops!', obj.message);

            }
        }
    }
    xmlHttpRequest.open('POST', 'process/verity_user.php', true);
    xmlHttpRequest.send(form);
}

const signin = () => {

    const email = document.getElementById('e2').value;
    const password = document.getElementById('p2').value
    const rememberMe = document.getElementById('remember').checked;

    const form = new FormData();
    form.append('email', email);
    form.append('password', password);
    form.append('rememberMe', rememberMe);

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            const obj = JSON.parse(xhr.responseText);
            if (obj.statusCode === 1) {
                showSuccessToast('Success!', obj.message);
                window.location.href = "index.php";
            } else {
                if (obj.message === "Your account is not verified") {
                    showErrorToast("OOPs!", obj.message);
                    hideViewComponent('signin', 'VCcontainer')
                } else {
                    showErrorToast("OOPs!", obj.message);
                }
            }
        }
    }

    xhr.open('POST', 'process/signin-user.php', true);
    xhr.send(form);
}

const adminSignin = () => {

    const email = document.getElementById('e2').value;
    const password = document.getElementById('p2').value
    const rememberMe = document.getElementById('remember').checked;

    const form = new FormData();
    form.append('email', email);
    form.append('password', password);
    form.append('rememberMe', rememberMe);

    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            const obj = JSON.parse(xhr.responseText);
            if (obj.statusCode === 1) {
                showSuccessToast('Success!', obj.message);
                window.location.href = "admin-panel.php";
            } else {

                showErrorToast("OOPs!", obj.message);

            }
        }
    }

    xhr.open('POST', 'process/signin-admin.php', true);
    xhr.send(form);
}
const addToWhishListInHome = (productID) => {

    if (document.getElementById("heartIcon_1_" + productID).classList.contains('bi-heart-fill')) {
        document.getElementById("heartIcon_1_" + productID).classList.remove('bi-heart-fill');
        document.getElementById("heartIcon_1_" + productID).classList.add('bi-heart');

        document.getElementById("heartIcon_2_" + productID).classList.remove('bi-heart-fill');
        document.getElementById("heartIcon_2_" + productID).classList.add('bi-heart');
    } else {
        document.getElementById("heartIcon_1_" + productID).classList.remove('bi-heart');
        document.getElementById("heartIcon_1_" + productID).classList.add('bi-heart-fill');

        document.getElementById("heartIcon_2_" + productID).classList.remove('bi-heart');
        document.getElementById("heartIcon_2_" + productID).classList.add('bi-heart-fill');
    }

    const xhr = new XMLHttpRequest();
    const form = new FormData();
    form.append('productID', productID);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            const obj = JSON.parse(xhr.responseText);
            if (obj.statusCode === 1) {
                showSuccessToast('Success!', obj.message);
            } else {
                showErrorToast('Oops!', obj.message);
                if(obj.message =="Login Required"){
                    location.href = 'login.php'
                }
            }
        }
    }
    xhr.open('POST', 'process/addRemoveWhishList.php', true);
    xhr.send(form)
}

const loadWishListsData = () => {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            // itemsCount
            const obj = JSON.parse(xhr.responseText);
            document.getElementById("whishListItemCount").innerHTML = obj.itemsCount + " Items";
            document.getElementById('WhishListItemBody').innerHTML = obj.items;

        }
    }
    xhr.open('GET', 'process/getWhishListItems.php', true);
    xhr.send()
}

const removeFromWhishList = (productID) => {
    const xhr = new XMLHttpRequest();
    const form = new FormData();
    form.append('productID', productID);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            const obj = JSON.parse(xhr.responseText);
            if (obj.statusCode === 1) {
                loadWishListsData();
                showSuccessToast('Success!', obj.message);
            } else {
                showErrorToast('Oops!', obj.message);
            }
        }
    }
    xhr.open('POST', 'process/addRemoveWhishList.php', true);
    xhr.send(form)
}


const AddToCart = (productID) => {
    const qty = document.getElementById('quentity_' + productID).value;

    if (SELECTEDPRODUCTSIZECOLOR[productID] === null || SELECTEDPRODUCTSIZECOLOR[productID] === undefined) {
        showErrorToast("Opps!", "please Select Size First!")
        return;
    } else if (SELECTEDPRODUCTSIZECOLOR[productID]["color"] === null || SELECTEDPRODUCTSIZECOLOR[productID]["color"] === undefined) {
        showErrorToast("Opps!", "please Select Color First!")
        return;
    } else if (SELECTEDPRODUCTSIZECOLOR[productID]["size"] === null || SELECTEDPRODUCTSIZECOLOR[productID]["size"] === undefined) {
        showErrorToast("Opps!", "please Select Size First!")
        return;
    } else if (qty == 0) {
        showErrorToast("Opps!", "please enter a product quentity")
    } else if (qty > 10) {
        showErrorToast("Opps!", "maximum  quentity is 10")
        document.getElementById('quentity_' + productID).value = 10;
    } else {
        const colorID = SELECTEDPRODUCTSIZECOLOR[productID]["color"];
        const sizeID = SELECTEDPRODUCTSIZECOLOR[productID]["size"];

        const xhr = new XMLHttpRequest();
        const form = new FormData();
        form.append('colorID', colorID);
        form.append("productID", productID);
        form.append('sizeID', sizeID);
        form.append('qty', qty);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
                const obj = JSON.parse(xhr.responseText);
                if (obj.statusCode === 1) {
                    showSuccessToast('Success!', obj.message);
                } else {
                    showErrorToast('Oops!', obj.message);
                    if(obj.message == "anouthenticated"){
                        location.href = "login.php"
                    }
                }
            }
        }

        xhr.open('POST', 'process/addToCart.php', true);
        xhr.send(form)


    }


}

const loadCartData = () => {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            // itemsCount
            const obj = JSON.parse(xhr.responseText);
            // document.getElementById("whishListItemCount").innerHTML = obj.itemsCount + " Items";
            document.getElementById('cardItemBody').innerHTML = obj.items;
            document.getElementById('cartProductCount').innerText = ": " + obj.productsCount;
            document.getElementById('cartShippingAddress').value = obj.shippingAddress;
            document.getElementById('cartSubTotal').innerText = ": $" + obj.subTotal;
            document.getElementById('cartshippingTotal').innerText = ": $" + obj.shippingTotal;
            document.getElementById('cartGrandTotal').innerText = ": $" + obj.total;


        }
    }
    xhr.open('GET', 'process/getCartItems.php', true);
    xhr.send()
}

const removeFromCart = (cartID) => {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            const obj = JSON.parse(xhr.responseText);
            if (obj.statusCode === 1) {
                showSuccessToast('Success!', obj.message);
                loadCartData();
            } else {
                showErrorToast('Oops!', obj.message);
            }
        }
    }
    xhr.open('GET', 'process/removeFromCart.php?cartID=' + cartID, true);
    xhr.send()
}

const confirmPayment = (orderID) => {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);

            const obj = JSON.parse(xhr.responseText);
            if (obj.statusCode === 1) {
                showSuccessToast('Success!', obj.message);
                loadAdminPages(2);
            } else {
                showErrorToast('Oops!', obj.message);
            }
        }
    }
    xhr.open('GET', 'process/confirmPayment.php?orderID=' + orderID, true);
    xhr.send()
}

const placeOrder = (orderID) => {
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);

            const obj = JSON.parse(xhr.responseText);
            if (obj.statusCode === 1) {
                showSuccessToast('Success!', obj.message);
                loadAdminPages(2);
            } else {
                showErrorToast('Oops!', obj.message);
            }
        }
    }
    xhr.open('GET', 'process/placeOrder.php?orderID=' + orderID, true);
    xhr.send()
}

const searchBoxOnchange = () => {
    document.getElementById('keyWords').value = document.getElementById('searchbox').value;
}
const keywordBoxOnchange = () => {
    document.getElementById('searchbox').value = document.getElementById('keyWords').value;
}
const searchProductWithFilters = () => {
    // const priceFrom = document.getElementById('priceFrom').value == null ? 0 : document.getElementById('priceFrom').value;
    // const priceTo = document.getElementById('priceTo').value == null ? 0 : document.getElementById('priceTo').value;
    // const categoryID = document.getElementById('category_select').value;
    // const colorName = document.getElementById('color_select').value;
    // const sortPrice = document.getElementById("HtoL").checked ? "HtoL" : "LtoH";
    // const keyWords = document.getElementById('keyWords').value;
    //
    // location.href = "search.php?priceFrom = "+priceFrom+ //TODO - make this Get Request


    const priceFrom = document.getElementById('priceFrom').value || 0; // Use default value if null
    const priceTo = document.getElementById('priceTo').value || 0; // Use default value if null
    const categoryID = document.getElementById('category_select').value;
    const colorName = document.getElementById('color_select').value;
    const sortPrice = document.getElementById("HtoL").checked ? "HtoL" : "LtoH";
    const keyWords = document.getElementById('keyWords').value;

    // Construct the URL
    let url = "searchProduct.php?";
    url += "priceFrom=" + encodeURIComponent(priceFrom); // Encode parameters to handle special characters
    url += "&priceTo=" + encodeURIComponent(priceTo);
    url += "&categoryID=" + encodeURIComponent(categoryID);
    url += "&colorName=" + encodeURIComponent(colorName);
    url += "&sortPrice=" + encodeURIComponent(sortPrice);
    url += "&keyWords=" + encodeURIComponent(keyWords);

    // Redirect to the constructed URL
    location.href = url;

}


const updateProduct = (productID) => {

    const request = new XMLHttpRequest();
    request.open("GET", 'pages/update-product.php?pid=' + productID, true)
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            console.log(request.responseText);
            const responseObj = JSON.parse(request.responseText);
            console.log(responseObj)
            if (responseObj.statusCode === 1) {

                document.getElementById("adminCenter").innerHTML = responseObj.body;
            } else {
                showErrorToast("update product page loading error ERROR", responseObj.message);
            }

            if (id == 7) {
                location.reload();
            }
        }
    }
    request.send()
}

const loadOrderProcessModelData = (id) => {
    document.getElementById('orderProcessModelID').innerText = "Order Status "+id+"";
    const request = new XMLHttpRequest();
    request.open("GET", 'process/viewOrderProcessModel.php?oid=' +id , true)
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            console.log(request.responseText);
            const responseObj = JSON.parse(request.responseText);
            console.log(responseObj)
            if (responseObj.statusCode === 1) {
                const items = responseObj.message;
                const processModelTimeline = document.getElementById('processModelTimeline');
                for (const item of items) {
                    const elementItem = `
<li class="timeline-item mb-5">
      <span class="timeline-icon">
      <i class="bi bi-info fs-2"></i>
      </span>

            <h5 class="fw-bold">${item['status']}</h5>
            <p class="text-muted mb-2 fw-bold">${item['date_time']}</p>
        </li>`
                    processModelTimeline.innerHTML += elementItem;
                }

            } else {
                showErrorToast("Error Update ", responseObj.message);
            }

            if (id == 7) {
                location.reload();
            }
        }
    }
    request.send()
}



const adminSearchProduct =()=>{

        let keyword = document.getElementById('keyword').value.trim();
        let category = document.getElementById('categoryOption').value;
        let size = document.getElementById('AddProductSize').value;
        let priceFrom = document.getElementById('priceFrom').value.trim();
        let priceTo = document.getElementById('priceTo').value.trim();

        if (keyword === null) {
            keyword = "";
        }

        if (category === null) {
            category = 0;
        }

        if (size === null) {
            size = 0
        }

        if (priceFrom === '' || isNaN(priceFrom)) {
            priceFrom = 0;
        }
        if (Number(priceFrom) < 0) {
            showErrorToast('Validation Error', 'Please enter a valid price from');
            return;
        }

        if (priceTo === '' || isNaN(priceTo)) {
            priceTo = 0;
        }
        if (Number(priceTo) < 0) {
            showErrorToast('Validation Error', 'Please enter a valid price to');
            return;
        }

        if (Number(priceFrom) > Number(priceTo)) {
            showErrorToast('Validation Error', 'Price from cannot be greater than price to');
            return;
        }

        const formData = new FormData();
        formData.append('keyword', keyword);
        formData.append('category', category);
        formData.append('size', size);
        formData.append('priceFrom', priceFrom);
        formData.append('priceTo', priceTo);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'process/adminsearchproduct.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                showSuccessToast('Success', 'Products fetched successfully');
                console.log(xhr.responseText);
                document.getElementById('productTableBody').innerHTML = xhr.responseText;
            } else {
                showErrorToast('Error', 'An error occurred while searching for products');
            }
        };
        xhr.send(formData);

}

const adminSearchDeleveredOrders =()=>{
// Get the search parameters
    const orderID = document.getElementById('orderID').value;
    const productID = document.getElementById('productID').value;
    const email = document.getElementById('email').value;

    const form = new FormData();
    form.append("orderID",orderID);
    form.append("productID",productID);
    form.append("email",email);

    // Create an XMLHttpRequest object
    const xhttp = new XMLHttpRequest();

    // Define what happens on successful data submission
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            const response = JSON.parse(this.responseText);
            if (response.statusCode === 1) {
                document.getElementById('tablebody').innerHTML = response.body;
            } else {
                alert('Error: ' + response.message);
            }
        }
    };

    // Define the request
    xhttp.open("POST", "process/adminSearchDeleveredOrder.php", true);

    // Send the request with the search parameters
    xhttp.send(form);
}