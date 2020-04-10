<?php
$type = $_GET["type"];
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');
$sqlt="select * from news where type= '$type'";
$sel = mysqli_query($con,$sqlt);
$data = array();

while ($row = mysqli_fetch_assoc($sel)) {
 $data[] = $row;
}
//echo $sqlt;
echo json_encode($data);
?>