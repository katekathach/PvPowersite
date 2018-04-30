<?php 
error_reporting(0);
//ini_set('display_errors', 1);
define("ENVIRONMENT", "production");
require_once('includes/class.db.php');
require_once('includes/session.php');
require('includes/underscore.php');
require_once('class.railcalc.php');
/*************/
try{
$db = new DB();
}catch(Exception $e) {
echo $e->getMessage();		
}
/************/
//form post data
$module_cell = htmlspecialchars($_POST["cell"]);
$moduleWidth = htmlspecialchars($_POST["modulewidth"]);
$moduleCount = htmlspecialchars($_POST["modulecount"]);
$codeVersion = htmlspecialchars($_POST["codeversion"]);
$tilt = htmlspecialchars($_POST["tilt"]);
$wind = htmlspecialchars($_POST["windvalue"]);
$snow = htmlspecialchars($_POST["snow"]);
$module_thickness = htmlspecialchars($_POST["modulethickness"]);
$rack_quantity = htmlspecialchars($_POST["racksqty"]);
$seismic = htmlspecialchars($_POST["seismic"]);

$_SESSION['pvmaxseismic'] 	= $seismic;
$_SESSION['moduleCell']  	= $module_cell;
$_SESSION['moduleWidth'] 	= $moduleWidth;
$_SESSION['moduleCount'] 	= $moduleCount;
$_SESSION['codeVersion'] 	= $codeVersion;
$_SESSION['pvmaxtilt'] 		= $tilt;
$_SESSION['pvmaxwind'] 		= $wind;
$_SESSION['pvmaxsnow'] 		= $snow;
$_SESSION['pvmaxmodule_thickness']  = $module_thickness;
$_SESSION['pvmaxrack_quantity'] 	= $rack_quantity;

$projectAddress    = htmlspecialchars($_POST['projectaddress']);
$projectZip        = htmlspecialchars($_POST['projzip']);
$projectCity = htmlspecialchars($_POST['City']);
$projectState = htmlspecialchars($_POST['State']);
$_SESSION['pvmaxprojectname']     = htmlspecialchars($_POST['projectname']);
$_SESSION['projectAddress'] = $projectAddress;
$_SESSION['projectZip'] = $projectZip;
$_SESSION['projectCity'] = $projectCity;
$_SESSION['projectState'] = $projectState;

$isLandscape = false;
$tolerance = 40;
$maxRail = 6200;
$minRail = 4200;
$moduleRow = 2;
/*********************************************************************/
// get database asce7-10
if($module_cell == 60 && $codeVersion == 'ASCE7-10'  && $seismic == 'non-seismic'){
 $code_7_10_60 = $db->get_pvmax_60cell_10($tilt, $wind , $snow);
//echo print_r($code_7_10_60);
}elseif($module_cell == 60 && $codeVersion == 'ASCE7-10'  && $seismic == 'seismic'){
$code_7_10_60 = $db->get_pvmax_60cell_10_seis($tilt, $wind , $snow);
//echo print_r($code_7_10_60);
}else if($module_cell == 60 && $codeVersion == 'ASCE7-05' && $seismic == "non-seismic" ){
$code_7_05_60 = $db->get_pvmax_60cell_05($tilt, $wind , $snow);
//echo "<pre>",print_r($code_7_05_60),"</pre>";
}elseif($module_cell == 60 && $codeVersion == 'ASCE7-05' && $seismic == "seismic"){
$code_7_05_60 = $db->get_pvmax_60cell_05_seis($tilt, $wind , $snow);
//echo print_r($code_7_05_60);
}

//get the table row from pv max 72 cell
if($module_cell == 72 && $codeVersion == 'ASCE7-05' && $seismic == 'non-seismic'){
   $code_7_05_72  = $db->get_pvmax_72cell_05($tilt, $wind, $snow);
  // echo print_r($code_7_05_72);
}elseif($module_cell == 72 && $codeVersion == 'ASCE7-05' && $seismic == 'seismic'){
   $code_7_05_72  = $db->get_pvmax_72cell_05_seis($tilt, $wind, $snow);
  // echo print_r($code_7_05_72);
}else if($module_cell == 72 && $codeVersion == 'ASCE7-10'  && $seismic == 'non-seismic'){
   $code_7_10_72 = $db->get_pvmax_72cell_10($tilt, $wind, $snow);
  // echo print_r($code_7_10_72);
}elseif($module_cell == 72 && $codeVersion == 'ASCE7-10'  && $seismic == 'seismic'){
   $code_7_10_72 = $db->get_pvmax_72cell_10_seis($tilt, $wind, $snow);
  // echo print_r($code_7_10_72);
}

/********************************************************************/

//System Length Calculation
$distance = $moduleWidth * $moduleCount; //inital length of modules
$sysLengthd = ceil(($moduleWidth * $moduleCount + (23 *($moduleCount-1)) + 80)); //add module clamp spacing and extra length just in case
$sysLength = floatval($sysLengthd);
$sysLengthIn = $sysLength * 0.0393701; //convert length from mm to in
$sysLengthft =  $sysLength * 0.00328084;

//Calculate Amount of Rail
//$railCount = (ceil(($sysLength / 6200)*4));
//Calculate Amount of Splice
//$spliceCount = ($railCount - 4);

//Calculate Amount of Rail
$sys = ($sysLength / 6200);
$whole = floor($sys);      //1

$fraction = $sys - $whole; //.25
if($fraction <= .25)
{ 
$sysCount = ceil(($sys * 4))/4;
}else{
$sysCount = ceil(($sys * 2))/2;
}
//echo " sys Count" .$sysCount;
//$railCount = ($sysCount * 4);


//Calculate Amount of Splice
//$spliceCounts = ($railCount - 4);
$spliceCount = (ceil($spliceCounts/4)*4);


//Find Design Type for results page
/*if ($design == 6){
	$designType = "Penetrating 6in. Standoff";
}else  if ($design == 4){
	$designType = "Penetrating 4in. Standoff";
}else {
	$designType = "Ballasted System";
}*/

//data base query
if ($module_cell == '60' && $codeVersion == 'ASCE7-10') {
foreach ($code_7_10_60  as $load => $key){
$span = $key['max_span'];
}
}
else if ($module_cell == '60' && $codeVersion == 'ASCE7-05'){
foreach ($code_7_05_60  as $load => $key){
$span = $key['max_span'];
}
}

//get the 72cell data
if ($module_cell == '72' && $codeVersion == 'ASCE7-10') {
foreach ($code_7_10_72  as $load => $key){
$span = $key['max_span'];
}
}
else if ($module_cell == '72' && $codeVersion == 'ASCE7-05'){
foreach ($code_7_05_72  as $load => $key){
$span = $key['max_span'];
}
}

//echo $supportTriCount = ceil(($sysLengthIn / 12) / $span); 	
//$length =  ceil(($sysLengthIn/12)) ;
// $supportTriCou = max(($length / $span),2);
//echo " support" . $supportTriCou;
//echo "<br>";
///find cantilever


$support = ceil($sysLengthft/ $span);
$support = max($support,2);
ceil($sysLengthft / $span);
$spantotal = ($support - 1) * $span;

$cantileverftpercentr = ($sysLengthft - $spantotal) / $span / 2 ;
$cantileverftpercent = round($cantileverftpercentr,5); 
$cantileverft =  $cantileverftpercent * $span;
$spanMM  = $span * 304.8;
//echo "span" . $spanMM;
//echo "<br>";
$cantileverMMr = $cantileverft * 304.8;
$cantileverMM = round($cantileverMMr,2);
//echo number_format(round($cantileverMM,1),2);

//splice percentage 25%
$splicePerct = .25;

//Calculate Amount of Support Triangles
//$supportTriCount = ceil(($sysLengthIn / 12) / $span); 	
$supportTriCount  = $support;
//Check for support issue: Project with only 2 supports in a rack can't have a rail splice per engineering
if ($railCount > 2 && $supportTriCount == 2){
echo '<script language="javascript">
alert("ENGINEERING ERROR:\nThis layout does not support rail splicing.  Please increase/decrease the number of module columns\n or contact a sales representative for additional assistance.");
window.location.href="form.php";
</script>';

}



//Find triangle product SAP# for tilt
function triangleTilt($tilt, $module_cell){

if ($tilt == 15 && $module_cell == 60){
	return "146002-215";
}
else if ($tilt == 20 && $module_cell == 60){
	return "146002-220";
}
else if ($tilt == 25 && $module_cell == 60){
	return "146002-225";
}
else if ($tilt == 30 && $module_cell == 60){
	return "146002-230";
}
else if ($tilt == 35 && $module_cell == 60){
	return "146002-235";
}
else if ($tilt == 20 && $module_cell == 72){
	return "146002-320";
}
else if ($tilt == 25 && $module_cell == 72){
	return "146002-325";
}
else if ($tilt == 30 && $module_cell == 72){
	return "146002-330";
}
else {
	return "error";
}
}
triangleTilt($tilt, $module_cell);
$triangleItem = triangleTilt($tilt, $module_cell);

/*$endClamp = $db->getAllClampsByThickness($module_thickness, 'end', 'portrait');
$endClamp = $endClamp[0];

$middleClamp = $db->getAllClampsByThickness($module_thickness, 'mid', 'portrait');
$middleClamp = $middleClamp[0];

//calculate endclamp and middle clamp quantity
$endclampqty = 8 ; 
 $middleClampqty  = ((($moduleCount * 2 ) - 2) * 2);

//get safety hook if endclamp is 3
if($endClamp['id'] == '1' ){
	$laminatehook =  $db->getLaminateSafetyHook('139008-003');
$laminatehook = $laminatehook[0];

};
//get safety hook if endclamp is 1
if($endClamp['id'] == '3' ){
	$laminatehook =  $db->getLaminateSafetyHook('139008-004');
$laminatehook = $laminatehook[0];

};

$laminatehookqty = ($moduleCount - 1) * 2;*/
// include rail calculation function 
include_once("functions.php");	
?>
