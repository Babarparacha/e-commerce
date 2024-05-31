<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

include("./db/db.php");

// Retrieve and sanitize input data
$userId = mysqli_real_escape_string($con, $_POST['userId']);
$productName = mysqli_real_escape_string($con, $_POST['productName']);
$productPrice = mysqli_real_escape_string($con, $_POST['productPrice']);
$quantity = mysqli_real_escape_string($con, $_POST['quantity']);
$productDetail = mysqli_real_escape_string($con, $_POST['productDetail']);
$date = date("d-m-Y");

// Handle file upload
$imageName = $_FILES['image']['name'];
$tempName = $_FILES['image']['tmp_name'];
$imageFolder = "productImages";

if (!file_exists($imageFolder)) {
    mkdir($imageFolder);
}
move_uploaded_file($tempName, "$imageFolder/$imageName");

// Check if product already exists
$query1 = "SELECT * FROM `product_detail` WHERE `product_name`='$productName'";
$result = mysqli_query($con, $query1);

if (mysqli_num_rows($result) > 0) {
    $data = array("code" => "400", "status" => false, "message" => "Product already exists");
} else {
    // Insert new product
    $query = "INSERT INTO `product_detail`(`user_id`, `product_name`, `product_price`, `total_quantity`, `quantity`, `detail`,`product_image`, `created_on`) 
              VALUES ('$userId', '$productName', '$productPrice', '$quantity', '1', '$productDetail','$imageName', '$date')";
    
    if (mysqli_query($con, $query)) {
        $data = array("code" => "200", "status" => true, "message" => "Product added successfully");
    } 
}

echo json_encode($data);
?>
