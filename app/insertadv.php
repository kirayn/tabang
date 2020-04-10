<?php
include 'db.connect.php';
$url = file_get_contents('php://input');
mysqli_set_charset( $con, 'utf8');

$data = json_decode($url, true);
$userId = $data['userId'];
$title = $data['title'];
$description = $data['description'];
$cost = $data['cost'];
$categoryId = $data['categoryId'];
$locationId = $data['locationId'];
$contactPerson = $data['contactPerson'];
$contactNumber = $data['contactNumber'];

$sql="INSERT INTO `adverts` (`advId`, `userId`, `title`, `description`, `cost`, `categoryId`, `locationId`, `validity`, `contactPerson`, `contactNumber`, `date`) VALUES (NULL, $userId, '$title', '$description', '$cost', '$categoryId', '$locationId', '60', '$contactPerson', '$contactNumber', CURRENT_TIMESTAMP)";

//$sql="INSERT INTO adverts ('advId', 'userId', 'title', 'description', 'categoryId', 'locationId', 'validity', 'contactPerson', 'contactNumber', 'date') VALUES (NULL, '2', $data['title'], $data['description'], $data['categoryId'], $data['locationId'], '60', $data['contactPerson'], $data['contactNumber'], CURRENT_TIMESTAMP)"; 
//echo $sql
$sel = mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);
mysqli_close($con);
$arr = array($sel, $lastId);
echo json_encode($arr);
?>