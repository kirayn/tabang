<?php
include 'db.connect.php';
$url = file_get_contents('php://input');
mysqli_set_charset( $con, 'utf8');

$data = json_decode($url, true);
$title = $data['title'];
$details = $data['details'];
$topicId = $data['topicId'];
$userId = $data['userId'];

$sql="INSERT INTO `queries`(`queryId`, `topicId`, `userId`, `title`, `details`, `date`, `status`) VALUES (null,$topicId,$userId,'$title','$details',CURRENT_TIMESTAMP,'active')";
//echo ($sql);
$sel = mysqli_query($con,$sql);
mysqli_close($con);
echo ($sel);
?>