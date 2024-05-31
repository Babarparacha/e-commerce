<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

include("./db/db.php");

// Retrieve and sanitize input data
$getData = mysqli_real_escape_string($con,$_POST['getData']);


if(isset($_POST['getData'])){

// Check if product already exists
$query1 = "SELECT `id`, `product_id`, `product_name`, `product_price`, `quantity_product`, `product_image`, `customer_name`, `customer_cell`, `customer_address`, `status`, `created_on`, `updated_on`, `deleted_on` FROM `orders` WHERE 1 ";
$result = mysqli_query($con, $query1);
if (mysqli_num_rows($result)) {
    while($row=mysqli_fetch_assoc($result)){
        $data[] = array
        ("id" => $row['id'],
        "product_id" => $row['product_id'],
         "product_name" => $row['product_name'], 
         "product_price" => $row['product_price'] ,
         "quantity_product" => $row['quantity_product'] ,
         "product_image" => $row['product_image'],
         "customer_name" => $row['customer_name'],
         "customer_cell" => $row['customer_cell'],
         "customer_address" => $row['customer_address'],
         "status" => $row['status'],
         "created_on" => $row['created_on']
        
        );
    }

} else {
   
        $data = array("code" => "400", "status" => true, "message" => "No Product to show");
    } 
}

echo json_encode($data);
?>
