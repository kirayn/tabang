<?php
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');

$userId = $_GET['userId'];
$token = $_GET['token'];

$chkSql="select ID from users where ID='$userId' and activation='$token'";
$num=mysqli_num_rows(mysqli_query($con,$chkSql));
//echo $chkSql;
if($num>0){
	$sql="select * from userprofiles where userId=$userId";
	$result=mysqli_query($con, $sql);
	$row=mysqli_fetch_assoc($result);
	echo json_encode($row);
}else{
	echo "unauthorised";
}
?>