<?php
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');
$sel = mysqli_query($con,"select * from categories where parentId = 2");
$data = array();

/*while ($row = mysqli_fetch_array($sel)) {
 $data[] = array("categoryId"=>$row['categoryId'],"name"=>$row['name'], "description"=>$row['description'], "image"=>$row['image']);
}
echo json_encode($data);*/
while($row = mysqli_fetch_assoc($sel)){
	$data[]=$row;
}
echo json_encode($data);
?>