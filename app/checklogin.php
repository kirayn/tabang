<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.connect.php';

mysqli_set_charset( $con, 'utf8');

$mobile = $_GET['userPhone'];
$otp = $_GET['otpw'];
$token = $_GET['token'];

if(strlen($mobile)==10){
	$sql="select ID, mobile, activation from users where mobile=$mobile";
	$result=mysqli_query($con, $sql);
	$numRow=mysqli_num_rows($result);
	
	if($numRow==1){
		$row=mysqli_fetch_assoc($result);
		//echo $userId;
		$_SESSION['userId']=$row['ID'];
		$_SESSION['phone']=$row['mobile'];
		$_SESSION['token']=$row['activation'];
		echo json_encode($row);
		
	}elseif ($numRow == 0) {
		//echo 1;
		$sqladd="INSERT INTO `users`(`ID`, `name`, `mobile`, `emailid`, `passcode`, `role`, `status`, `activation`, `registered`) VALUES (null,null,'$mobile',null,$otp,'subscriber','np','$token',CURRENT_TIMESTAMP)";
			//echo ($sqlAddProfile);
		
		mysqli_query($con, $sqladd);

		$sql="select ID, mobile, activation from users where mobile=$mobile and activation='$token'";
		$result=mysqli_query($con, $sql);
		$row=mysqli_fetch_assoc($result);
		$_SESSION['userId']=$row['ID'];
		$_SESSION['phone']=$row['mobile'];
		$_SESSION['token']=$row['activation'];
		echo json_encode($row);
		
		$userId=$row['ID'];
		$sqlAddProfile="INSERT INTO `userprofiles`(`profileId`, `userId`, `firstName`, `lastName`, `address`, `village`, `city`, `pincode`, `source`, `agent`, `date`, `status`) VALUES (null,$userId,null,null,null,null,null,null,'app',0,CURRENT_TIMESTAMP,'ue')";
		
		mysqli_query($con, $sqlAddProfile);
	}


    //include "sendotp.php";
}
?>