<?php
include('./db/db.php');
$obj = json_decode(file_get_contents('php://input'), true);
$username = $obj['username'];
$password = $obj['password'];

 $query = "SELECT * FROM `user` WHERE `phone` = '$username' AND `password` = '$password' AND `deleted_on`='0'";
$connection = mysqli_query($con, $query);
$count = mysqli_num_rows($connection);
if ($count > 0) {
    while ($row = mysqli_fetch_array($connection)) {
        $id = $row['id'];
        $user_contact = $row['phone'];
        $type = $row['type'];
       
            $data[] = array("code" => '200', "id" => $id, "phone" => $user_contact,'type'=>$type);

   }
} else {
    $data = '420';
}


echo json_encode($data);