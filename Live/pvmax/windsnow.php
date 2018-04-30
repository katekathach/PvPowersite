<?php 
//error_reporting(-1);
// Get config file.
require_once('includes/class.db.php');
//var_dump($_POST);
$system = "pvmax";
/*************/
try{
$db = new DB();
}catch(Exception $e) {
echo $e->getMessage();		
}
/************/
$cell =  $_POST['c'];
$code   =  $_POST['co'];
$tilt = $_POST['t'];
$seis = $_POST['s'];

$windres = $db->getWind($system , $tilt, $cell , $code , $seis);
//json_encode($windres);

$snowres = $db->getSnow($system , $tilt, $cell , $code, $seis );
$newarr = array_merge($windres,$snowres);
echo json_encode($newarr);
?>