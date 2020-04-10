<?php
//$catId = $_GET["categoryId"];
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');

if(isset($_GET['queryId'])){
	$queryId = $_GET['queryId'];
	$postType = $_GET['postType'];
	$sql="select comments.commentId,
	comments.queryId, comments.userId, userprofiles.firstName, userprofiles.lastName, comments.details, comments.image, comments.date
	from comments LEFT JOIN userprofiles on userprofiles.userId = comments.userId
	WHERE comments.queryId=$queryId AND comments.postType='$postType'";
	//echo $sql;
	$sel = mysqli_query($con,$sql);
	$data = array();

	while ($row = mysqli_fetch_assoc($sel)) {
	 $data[] = $row;
	}
	echo json_encode($data);
}

if(isset($_POST['queryId'])){
	$location = '../media/';
	$queryId=$_POST['queryId'];
	$userId=$_POST['userId'];
	$details=$_POST['details'];
	$postType=$_POST['postType'];
	$filename=Null;
	if(isset($_FILES['file'])){
		$imageFile=$_FILES['file']['name'][0];
		$filename=$queryId."-".$imageFile;
		move_uploaded_file($_FILES['file']['tmp_name'][0],$location.$filename);
	}

	$sql="INSERT INTO `comments` (`commentId`, `queryId`, `userId`, `details`, `image`, `date` , `postType`) VALUES (null, $queryId, $userId, '$details', '$filename', CURRENT_TIMESTAMP, '$postType')";
	$sel = mysqli_query($con,$sql);
	mysqli_close($con);
	echo ($sel);
}

$_POST = json_decode(file_get_contents('php://input'), true);

if(isset($_POST['commentId'])){
	$postType=$_POST['postType'];
	$commentId=$_POST['commentId'];
	$idEntity=$_POST['idEntity'];
	$userId=$_POST['userId'];
	$sql="DELETE FROM comments where commentId=$commentId and userId=$userId and postType='$postType'";
	$sel = mysqli_query($con,$sql);

	if($postType=='adv'){
		$updatesql="UPDATE `adverts` SET comments=comments - 1 WHERE advId=$idEntity";
		$update=mysqli_query($con,$updatesql);
	}
	echo $sel;
}
?>