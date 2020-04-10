<?php
$advId = $_GET["advId"];
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');
$sqlt="select * from media where advId= $advId";
$sel = mysqli_query($con,$sqlt);
$data = array();

while ($row = mysqli_fetch_assoc($sel)) {
 $data[] = $row;
}
echo json_encode($data);
?>