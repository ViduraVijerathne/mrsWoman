<?php
global $SUCCESS;
global $ERROR;
require_once "../const/statesCodes.php";
require_once "../database/Database.php";
$obj = new stdClass();
if (!isset($_POST["productName"])) {
//    length validation max 100
    $obj->message = "product name is missing";
    $obj->statusCode = $ERROR;
} else if (!isset($_POST["productDescription"])) {
    $obj->message = " product description is missing";
    $obj->statusCode = $ERROR;

} else if (!isset($_FILES["productImages"])) {
    $obj->message = " product images is missing";
    $obj->statusCode = $ERROR;
} else if (strlen($_POST["productName"]) > 100) {
    $obj->message = " product name is too long";
    $obj->statusCode = $ERROR;
} else if (strlen($_POST["productDescription"]) > 500) {
    $obj->message = " product description is too long";
    $obj->statusCode = $ERROR;
} else if (count($_FILES["productImages"]["size"]) > 3) {
    $obj->message = " product images is too many" . count($_FILES["productImages"]);
    $obj->statusCode = $ERROR;
}else if(!isset($_POST['category'])){
    $obj->message = "Product category is not selected";
    $obj->statusCode = $ERROR;
}
else {

//    ADD PRODUCT
    $db = new \database\Database();
    $AddProductQuery = 'INSERT INTO product (product_name, product_description,category_id) 
                        VALUES (:productName, :productDesc,:catID);';
    $params = [
        ':productName' => $_POST["productName"],
        ':productDesc' => $_POST["productDescription"],
        ':catID' => $_POST["category"]
    ];

    $productID = $db->insertAndGetId($AddProductQuery, $params);
    if ($productID > 0) {

//        ADD PRODUCT IMAGE
        // Array of allowed file extensions
        $allowed = array("jpeg", "jpg", "png", "webp");
        for ($i = 0; $i < count($_FILES["productImages"]["size"]); $i++) {
            $fileName = $_FILES["productImages"]["name"][$i];
            $fileSize = $_FILES["productImages"]["size"][$i];
            $fileTmpName = $_FILES["productImages"]["tmp_name"][$i];
            $fileError = $_FILES["productImages"]["error"][$i];
            $fileType = $_FILES["productImages"]["type"][$i];
            $fileExt = explode(".", $fileName);
            $fileActualExt = strtolower(end($fileExt));

            if (in_array($fileActualExt, $allowed)) {
                $forDBDirectory = "src/images/product_images/";
                $uploadDirectory = "../" . $forDBDirectory;
                // Generate a unique file name to avoid overwriting existing files
                $uniqueFileName = uniqid('', true) . '.' . $fileActualExt;
                // Move the uploaded file to the desired directory
                $destinationPath = $uploadDirectory . $uniqueFileName;
                if (move_uploaded_file($fileTmpName, $destinationPath)) {
                    $addImageQuery = "INSERT INTO product_images (path) VALUES (:path);";
                    $params = [
                        ':path' => $forDBDirectory . $uniqueFileName,
                    ];
                    $imageID = $db->insertAndGetId($addImageQuery, $params);
                    if ($imageID > 0) {
                        $addProductImageQuery = "INSERT INTO product_images_has_product (product_images_image_id, product_product_id) VALUES (:imgId, :pId);";
                        $params = [
                            ':imgId' => $imageID,
                            ':pId' => $productID
                        ];
                        $db->query($addProductImageQuery);
                        $db->bind(':imgId', $imageID);
                        $db->bind(':pId', $productID);
                        $db->execute();

                        $obj->statusCode = $SUCCESS;
                        $obj->message = "image upload Database Succces111 ";
                    } else {
                        $obj->statusCode = $ERROR;
                        $obj->message = "image upload Database failed ";
                    }
                } else {
                    $obj->statusCode = $ERROR;
                    $obj->message = "image upload failed ";
                }


            } else {
                $obj->statusCode = $ERROR;
                $obj->message = "upload file type is not allowed";
            }


        }

//        ADDING PRODUCT STOCK
        $stockArray = json_decode($_POST['AddProductStock']);
        for ($i = 0; $i < count($stockArray); $i++) {


            $colorID = addColors($stockArray[$i]->colorName, $stockArray[$i]->colorCode);
            $sizeID = $stockArray[$i]->sizeID;
            $price = $stockArray[$i]->price;
            $qty = $stockArray[$i]->qty;
            $ship = $stockArray[$i]->delivery;

            $stockQuery = "INSERT INTO `web_viver`.`stock` 
    (`stock_price`, `color_color_id`, `size_size_iid`, `product_product_id`, `qty`, `shipping_cost`) 
VALUES (:price,:colorID,:sizeID,:productID,:qty,:shippingCost)";
            $params = [
                ':price' => $price,
                ':colorID' => $colorID,
                ':sizeID' => $sizeID,
                ':productID' => $productID,
                ':qty' => $qty,
                ':shippingCost' => $ship,
            ];
            $db->insertAndGetId($stockQuery,$params);

//
//            $stockID = $db->insertAndGetId($stockQuery,$params);
//            $obj->message = $stockID;

        }
        $obj->statusCode = $SUCCESS;
        $obj->message = "Successfully";

//        $obj -> message = count($stockArray);
    } else {
        $obj->statusCode = $ERROR;
        $obj->message = "Something went wrong : ADD PRODUCT TO DB";
    }
//    $obj -> message = json_encode(count($_FILES["productImages"]["size"]));


}

function addColors($colorName, $colorHex)
{
    $db = new \database\Database();
    $q = "INSERT INTO color (color_name,color_hex) VALUES (:color, :hex)";
    $params = [
        ':color' => $colorName,
        ':hex' => $colorHex
    ];
    $id = $db->insertAndGetId($q, $params);
    return $id;
}


echo json_encode($obj);



