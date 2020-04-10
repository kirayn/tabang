<?php
//$catId = $_GET["categoryId"];
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');
$queryId = $_GET['queryId'];
$sqlt="select queries.queryId,
 queries.topicId, topics.title as tTitle, queries.userId, userprofiles.firstName, userprofiles.lastName, queries.title as qTitle, queries.details, queries.date
 FROM queries 
 LEFT JOIN topics on topics.topicId = queries.topicId
 LEFT JOIN userprofiles on userprofiles.userId = queries.userId 
WHERE queries.queryId = $queryId";
 //echo $sqlt;
$sel = mysqli_query($con,$sqlt);
$data = array();

while ($row = mysqli_fetch_assoc($sel)) {
 $data[] = $row;
}
echo json_encode($data);
?>