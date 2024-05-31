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
$query1 = "SELECT `id`, `user_id`, `product_name`, `product_price`, `total_quantity`, `quantity`, `detail`, `product_image`, `created_on` FROM `product_detail` ";
$result = mysqli_query($con, $query1);
if (mysqli_num_rows($result)) {
    while($row=mysqli_fetch_assoc($result)){
        $data[] = array
        ("id" => $row['id'],
         "product_name" => $row['product_name'], 
         "product_price" => $row['product_price'] ,
         "total_quantity" => $row['total_quantity'] ,
         "product_image" => $row['product_image'],
         "created_on" => $row['created_on']
        
        );
    }

} else {
   
        $data = array("code" => "400", "status" => true, "message" => "Product added successfully");
    } 
}

echo json_encode($data);
?>
