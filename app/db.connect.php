<?php
ob_start();

$host = "localhost"; 
$user = "root";
$password = "";
$dbname = "tabelos";  

/*$host = "localhost"; 
$user = "tabel5yg_khedut";
$password = "Overland#9"; 
$dbname = "tabel5yg_tabelo"; */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Database Not Connected. Please try after some time." . mysqli_connect_error());
}