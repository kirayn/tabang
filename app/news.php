<?php
$id = $_GET["id"];
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');

$sqlt="select * from news where newsId= '$id'";
$sel = mysqli_query($con,$sqlt);
$data = array();

while ($row = mysqli_fetch_assoc($sel)) {
 $data[] = $row;
}
//echo $sqlt;
echo json_encode($data);
?>