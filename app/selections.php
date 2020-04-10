<?php
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');

$property = $_GET['prop'];
$value = $_GET['value'];

switch ($property) {
	case "topics":
		$sql="SELECT topicId, title from topics";
		break;
	
	case "categories":
		$sql="SELECT categoryId, name from categories where categoryId>2";
		break;

	case "location":
		$sql="SELECT locationId, title from locations";
		break;

	default:
		# code...
		break;
}

$sel = mysqli_query($con,$sql);
$data = array();

while($row = mysqli_fetch_assoc($sel)){
	$data[]=$row;
}

echo json_encode($data);
?>