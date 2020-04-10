<?php
include 'db.connect.php';

$sel = mysqli_query($con,"select * from config");
$data = array();

while ($row = mysqli_fetch_array($sel)) {
 $data[] = array("key"=>$row['confikey'],"value"=>$row['value']);
}
echo json_encode($data);
?>