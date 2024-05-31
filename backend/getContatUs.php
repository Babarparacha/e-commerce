<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

include("./db/db.php");

// Retrieve and sanitize input data
$getData = mysqli_real_escape_string($con,$_POST['getData']);


if(isset($_POST['getData'])){

    $fileName = "./contactUs/file.txt";
    $trimmed = file($fileName);
    $data = [];
    foreach ($trimmed as $line) {
        $arr = explode('~@~', $line);
        $email = $arr[0];
        $detail = $arr[1];
        $time = $arr[2];
        $data[] = array(

            'email' => $email,
            'detail' => $detail,
            'time' => $time
        );
    }
}

else {
   
        $data = array("code" => "400", "status" => false, "message" => "No complaint");
    } 


echo json_encode($data);
?>
