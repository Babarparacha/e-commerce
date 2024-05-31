<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

include("./db/db.php");

// Retrieve and sanitize input data
$id = $_POST['id'];
$type = $_POST['type'];
$addQ = $_POST['addQ'];
$previousQty = 0;

$date = date("d-m-Y");

// Fetch the previous quantity
$selectQuery = "SELECT * FROM `product_detail` WHERE `id`='$id'";
$mainResult = mysqli_query($con, $selectQuery);

while($rows = mysqli_fetch_array($mainResult)) {
    $previousQty = $rows['total_quantity'];
}

// Ensure variables are treated as integers
$previousQty = (int)$previousQty;
$addQ = (int)$addQ;

if($type == "deleteItem") {
    $query1 = "DELETE FROM `product_detail` WHERE `id`='$id'";
    $result = mysqli_query($con, $query1);
    if($result) {
        $data = "201";
    } else {
        $data = "401";
    }
} else {
    $previousSumQty = $previousQty + $addQ;
    $query2 = "UPDATE `product_detail` SET `total_quantity`='$previousSumQty', `updated_on`='$date' WHERE `id`='$id'";
    $result2 = mysqli_query($con, $query2);
    if($result2) {
        $data = "200";
    } else {
        $data = "400";
    }
}

echo json_encode($data);
?>
