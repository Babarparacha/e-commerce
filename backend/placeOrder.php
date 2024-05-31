<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

include("./db/db.php");

$cart = json_decode($_POST['cart'], true);

$checkQuantity=0;

$userName = mysqli_real_escape_string($con, $_POST['userName']);
$userCell = mysqli_real_escape_string($con, $_POST['userCell']);
$userAddress = mysqli_real_escape_string($con, $_POST['userAddress']);
$date = date('d-m-Y');

$data = array();

foreach ($cart as $item) {
    $productId    = $item['id'];
    $productName  = $item['name'];
    $productPrice = $item['price'];
    $quantity     = $item['quantity'];
    $image        = $item['image'];
   
    $queryForQuantity= "SELECT * FROM `product_detail` WHERE `id`='$productId'";
    $runquery=mysqli_query($con,$queryForQuantity);
    while($resultQ=mysqli_fetch_assoc($runquery)){
        $checkQuantity=$resultQ['total_quantity'];
    }
    if($checkQuantity>0){

  
    $query1 = "INSERT INTO `orders`(`product_id`, `product_name`, `product_price`, `quantity_product`, `product_image`, `customer_name`, `customer_cell`, `customer_address`,`status`, `created_on`) 
                VALUES ('$productId', '$productName', '$productPrice', '$quantity', '$image', '$userName', '$userCell', '$userAddress','new', '$date')";

    if (mysqli_query($con, $query1)) {
        $query="SELECT * FROM `product_detail` WHERE `id`='$productId'";
        $run=mysqli_query($con,$query);
        $row=mysqli_fetch_assoc($run);

        $quantityProduct=$row['total_quantity'];

        $quantityProduct=$quantityProduct-$quantity;

        $query2="UPDATE `product_detail` SET `total_quantity`='$quantityProduct' WHERE `id`='$productId'";
        $run2=mysqli_query($con,$query2);
        if($run2){

            $data= array("code" => '200', "status" => true, "message" => "Product added successfully");
        }
    } else {
        $data = array("code" => '400', "status" => false, "message" => "Error adding product: " . mysqli_error($con));
    }
}
else{
    $data = array("code" => '404');
}
}

echo json_encode($data);

?>
