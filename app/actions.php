<?php
include 'db.connect.php';
$url = file_get_contents('php://input');
mysqli_set_charset( $con, 'utf8');

$_POST = json_decode($url, true);

$typeEntity=$_POST['typeEntity'];
$idEntity=$_POST['idEntity'];
$typeAction=$_POST['typeAction'];
$userId=$_POST['idUser'];
$commentId=$_POST['idComment'];
$content=$_POST['content'];

$num=10;

if($typeEntity=="adv" && $typeAction="like"){

	$sqlChkRec="SELECT idEntity from actions WHERE `idEntity` = $idEntity AND `idUser` = $userId AND `typeEntity` = '$typeEntity' AND `typeAction` = '$typeAction' ";
	$num=mysqli_num_rows(mysqli_query($con,$sqlChkRec));
	
	if($num==0){
		$sql="INSERT INTO `actions` ( `idEntity`, `idUser`, `idComment`, `typeEntity`, `typeAction`, `content` ) VALUES ($idEntity, $userId, $commentId, '$typeEntity', '$typeAction', NULL )";
		$sel = mysqli_query($con,$sql);
		$updatesql="UPDATE `adverts` SET likes=likes + 1 WHERE advId=$idEntity";
		$update=mysqli_query($con,$updatesql);
	}
}
if($typeEntity=="adv" && $typeAction="cmnt"){
		$updatesql="UPDATE `adverts` SET comments=comments + 1 WHERE advId=$idEntity";
		$update=mysqli_query($con,$updatesql);
}
echo $num;

?>