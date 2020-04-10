<?php
include 'db.connect.php';
mysqli_set_charset( $con, 'utf8');
// Location
$location = '../media/';

// Count total files
$countfiles = count($_FILES['file']['name']);
$advId=$_POST['advId'];

$filename_arr = array(); 
// Looping all files
for ( $i = 0;$i < $countfiles;$i++ ){
   	$filename = $advId."-".$_FILES['file']['name'][$i];  
   	// Upload file
   	move_uploaded_file($_FILES['file']['tmp_name'][$i],$location.$filename);
    
  	$filename_arr[] = $filename;
}
for ( $i = 0;$i < $countfiles;$i++ ){
	$values[]='(null, '.$advId.', "'.$filename_arr[$i].'", null)';
}
$sql="INSERT INTO media (mediaId, advId, filename, thumbnail) VALUES ".implode(',', $values);
$sel = mysqli_query($con,$sql);
echo $sel;
echo $sql;
$arr = array('name' => $filename_arr);
echo json_encode($arr);

//print_r($values);