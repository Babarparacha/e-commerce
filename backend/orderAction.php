<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

include("./db/db.php");

$id = mysqli_real_escape_string($con,$_POST['id']);
$product_id = mysqli_real_escape_string($con,$_POST['product_id']);
$quantity = mysqli_real_escape_string($con,$_POST['quantity']);
$type = mysqli_real_escape_string($con,$_POST['type']);
$productQuantity=0;

$date = date("d-m-Y");
 $query="SELECT * FROM `product_detail` WHERE `id`='$product_id'";
$result = mysqli_query($con, $query);
while($row=mysqli_fetch_assoc($result)){
    $productQuantity=$row['total_quantity'];
}

if($type == "remove") {

    $query1 = "DELETE FROM `orders` WHERE `id`='$id'";
    $result = mysqli_query($con, $query1);
    if($result) {
        $totalQuantity=$quantity+$productQuantity;
        $queryAdd="UPDATE `product_detail` SET `total_quantity`='$totalQuantity' WHERE `id`='$product_id'";
        $runresult = mysqli_query($con, $queryAdd);
        $data = "201";
    } else {
        $data = "401";
    }
} else {
     $query2 = "UPDATE `orders` SET `status`='delivered', `updated_on`='$date' WHERE `id`='$id'";
    $result2 = mysqli_query($con, $query2);
    if($result2) {
        $data = "200";
    } else {
        $data = "400";
    }
}

echo json_encode($data);
?>