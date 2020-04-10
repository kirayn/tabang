<?php
$advId = $_GET["advId"];
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');
$sqlt="select 
adverts.advId, adverts.userId, adverts.title, adverts.description, adverts.cost, adverts.locationId, adverts.contactPerson, adverts.contactNumber, adverts.likes, adverts.comments, locations.title AS ltitle
FROM adverts join locations
ON locations.locationId = adverts.locationId
WHERE adverts.advId=$advId";

$sel = mysqli_query($con,$sqlt);
$data = array();

while ($row = mysqli_fetch_array($sel)) {
 $data[] = $row;
}
echo json_encode($data);
?>