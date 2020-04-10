<?php
$catId = $_GET["categoryId"];
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');
$sqlt="select
adverts.advId, adverts.userId, adverts.title, adverts.description, adverts.cost, adverts.locationId, adverts.contactPerson, adverts.contactNumber, adverts.likes, adverts.comments, locations.title AS ltitle, media.filename
FROM adverts 
JOIN locations ON locations.locationId = adverts.locationId
LEFT JOIN media on media.advId=adverts.advId 
WHERE adverts.categoryId=$catId
ORDER BY adverts.advId DESC";
$sel = mysqli_query($con,$sqlt);
$data = array();

while ($row = mysqli_fetch_assoc($sel)) {
 $data[] = $row;
}
echo json_encode($data);
//echo $sqlt;
?>