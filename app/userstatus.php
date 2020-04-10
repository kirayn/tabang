<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.connect.php';

mysqli_set_charset( $con, 'utf8');

$mobile = $_GET['mobile'];
$token = $_GET['token'];
$userId = $_GET['userId'];
if(isset($_SESSION['token']) && $_SESSION['token']==$token && isset($_SESSION['userId']) && $_SESSION['userId']==$userId){
	echo "pass";
}else{
	$sql="select ID, mobile, activation from users where ID=$userId and mobile='$mobile' and activation='$token'";
	//echo $sql;
	$result=mysqli_query($con, $sql);
	$row=mysqli_num_rows($result);
	//$mobiledata=$row['mobile'];
	//$tokendata=$row['activation'];

	if($row>=1){
		$_SESSION['logged_in'] = true;
		$_SESSION['userId'] = $userId;
		$_SESSION['username'] = $mobile;
		$_SESSION['token'] = $token;
		echo "pass";
	}else{
		echo "fail";
	}
}

/*if(isset($_SESSION['phone']) && isset($_SESSION['token'])){
	if($mobile==$_SESSION['phone'] && $token==$_SESSION['token']){
		echo "pass";
	}else{
		echo "fail";
	}
}else{
	echo "fail";
}*/
?>