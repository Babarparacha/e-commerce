<?php
include('./db/db.php');
$obj = json_decode(file_get_contents('php://input'), true);
$email = $obj['email'];
$detail = $obj['detail'];
$date=date("d-m-Y");

$filename ="contactUs";
if(!file_exists($filename)){
  mkdir($filename);
}

$LocationName="$filename/file.txt";
$file = fopen($LocationName, "a+");
    $data = $email."~@~".$detail."~@~".$date."\n";
    fwrite($file, $data);
    fclose($file);
    echo json_encode(array("status" => "success"));

    ?>