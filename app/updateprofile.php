<?php
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');

$_POST = json_decode(file_get_contents('php://input'), true);

$userId = $_POST['userId'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$address = $_POST['address'];
$village = $_POST['village'];
$city = $_POST['city'];
$pincode = $_POST['pincode'];

$sql="UPDATE `userprofiles` SET `firstName` = '$firstname', `lastName` = '$lastname', `address` = '$address', `village` = '$village', `city` = '$city', `pincode` = '$pincode' WHERE `userprofiles`.`userId` = $userId;";
$result=mysqli_query($con, $sql);
//echo $sql;
?>