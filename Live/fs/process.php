<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//define("ENVIRONMENT", "development");
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
/***********************************************************************************************************/
//form post data

$module_cell = htmlspecialchars($_POST["cell"]);
$moduleWidth = htmlspecialchars($_POST["modulewidth"]);
$moduleCount = htmlspecialchars($_POST["modulecount"]);
$codeVersion = htmlspecialchars($_POST["codeversion"]);
$tilt        = htmlspecialchars($_POST["tilt"]);
$wind        = htmlspecialchars($_POST["windvalue"]);
$snow        = htmlspecialchars($_POST["snow"]);
$module_thickness = htmlspecialchars($_POST["modulethickness"]);
$rack_quantity    = htmlspecialchars($_POST["racksqty"]);
$type_of_rack     = htmlspecialchars($_POST["foundation"]);
$seismic          = htmlspecialchars($_POST["seismic"]);

$_SESSION['fsseismic'] 			= $seismic;
$_SESSION['fsmoduleCell']       = $module_cell;
$_SESSION['fsmoduleWidth']      = $moduleWidth;
$_SESSION['fsmoduleCount']      = $moduleCount;
$_SESSION['fscodeVersion']      = $codeVersion;
$_SESSION['fstilt'] 	        = $tilt;
$_SESSION['fswind']	            = $wind;
$_SESSION['fssnow'] 	        = $snow;
$_SESSION['fsmodule_thickness'] = $module_thickness;
$_SESSION['fsrack_quantity']    = $rack_quantity;

$projectAddress    = htmlspecialchars($_POST['projectaddress']);
$projectZip        = htmlspecialchars($_POST['projzip']);
$projectCity = htmlspecialchars($_POST['City']);
$projectState = htmlspecialchars($_POST['State']);
$_SESSION['projectname'] = htmlspecialchars($_POST['projectname']);

$_SESSION['projectAddress'] = $projectAddress;
$_SESSION['projectZip'] = $projectZip;
$_SESSION['projectCity'] = $projectCity;
$_SESSION['projectState'] = $projectState;

$maxRail = 6200;
$minRail = 4200;
$moduleRow = 2;

//$code_7_05 = "";
//$code_7_10 = "";
/***********************************************************************************************************/
// get database asce7-10
if($module_cell == 60 && $codeVersion == 'ASCE7-10' && $seismic == 'non-seismic'){
 $code_7_10 = $db->get_FS_60_7_10_ns($tilt, $wind , $snow);
//echo print_r($code_7_10);
}
else if($module_cell == 60 && $codeVersion == 'ASCE7-05' && $seismic == 'non-seismic' ){
 $code_7_05 = $db->get_FS_60_07_05_ns($tilt, $wind , $snow);
//echo print_r($code_7_05);
}else if($module_cell == 60 && $codeVersion == 'ASCE7-05' && $seismic == 'seismic' ){
 $code_7_05 = $db->get_FS_60_07_05_s($tilt, $wind , $snow);
}else if($module_cell == 60 && $codeVersion == 'ASCE7-10' && $seismic == 'seismic'){
 $code_7_10 = $db->get_FS_60_7_10_s($tilt, $wind , $snow);
 	
}

//get the table row from pv max 72 cell
if($module_cell == 72 && $codeVersion == 'ASCE7-05' && $seismic == 'non-seismic'){
 //echo "72 05 ns called";
  $code_7_05  = $db->get_FS_72_7_05_ns($tilt, $wind, $snow);
 
 //echo print_r($code_7_05);
}else if($module_cell == 72 && $codeVersion == 'ASCE7-05' && $seismic == 'seismic'){
  //  echo "72 05  s called";
  $code_7_05  = $db->get_FS_72_7_05_s($tilt, $wind, $snow);
 
   // echo print_r($code_7_05);
}else if($module_cell == 72 && $codeVersion == 'ASCE7-10' && $seismic == 'non-seismic'){
  // echo "72 10 ns called";
   $code_7_10 = $db->get_FS_72_7_10_ns($tilt, $wind, $snow);
  
   // echo print_r($code_7_10);
}else if($module_cell == 72 && $codeVersion == 'ASCE7-10' && $seismic == 'seismic'){
  //  echo "72 10 s called";
  $code_7_10 = $db->get_FS_72_7_10_s($tilt, $wind, $snow);
   // echo print_r($code_7_10);
   
   
}

if(isset($code_7_05)){
	//echo "yes";
 	 $_SESSION['code'] = $code_7_05;   	
  }elseif(isset( $code_7_10)){
  	//echo "yes";
  	$_SESSION['code'] = $code_7_10;
 }

function error($code){
if(empty($code_7_05) || empty($code_7_10)){	
return  "ERROR - Record doesn't exist in database";	
}else {return "";}
}
/************************************************************************************************************/
$isLandscape = false;
$tolerance = 40;
$moduleDiedLoad = 18.6; 


//System Length Calculation
$distance = $moduleWidth * $moduleCount; //inital length of modules
$sysLengthd = ceil(($moduleWidth * $moduleCount + (23 *($moduleCount-1)) + 80)); //add module clamp spacing and extra length just in case
$sysLength = floatval($sysLengthd);
$sysLengthIn = $sysLength * 0.0393701; //convert length from mm to in
$sysLengthft =  $sysLength * 0.00328084;
//echo ceil(($sysLength / 6200)*4);
//Calculate Amount of Rail
$sys = ($sysLength / 6200);
$whole = floor($sys); // 1

$fraction = $sys - $whole; //.25
if($fraction <= .25)
{ 
$sysCount = ceil(($sys * 4))/4;

}else{
$sysCount = ceil(($sys * 2))/2;
}

//echo $sysCount;
//$railCount = ($sysCount * 4);


 "module width " . $_SESSION['fsmoduleWidth'];

 "module count " . $moduleCount;

 "system length " . $sysLength . " mm";

 "system length ft " . round($sysLengthft,2) . " ft";

 "rail count " . $railCount;


//Calculate Amount of Splice
$spliceCounts = ($railCount - 4);
$spliceCount = (ceil($spliceCounts/4)*4);


//Find Design Type for results page
if ($design == 6){
	$designType = "Penetrating 6in. Standoff";
}else  if ($design == 4){
	$designType = "Penetrating 4in. Standoff";
}else {
	$designType = "Ballasted System";
}

//Data base query
if ($module_cell == '60' && $codeVersion == 'ASCE7-10') {
foreach ($code_7_10  as $load => $key){
 $span = $key['max_span'];
}
}
else if ($module_cell == '60' && $codeVersion == 'ASCE7-05'){
foreach ($code_7_05  as $load => $key){
 $span = $key['max_span'];
}
}

//get the 72cell data
if ($module_cell == '72' && $codeVersion == 'ASCE7-10') {
foreach ($code_7_10  as $load => $key){
$span = $key['max_span'];
}
}
else if ($module_cell == '72' && $codeVersion == 'ASCE7-05'){
foreach ($code_7_05  as $load => $key){
$span = $key['max_span'];
}
}

//$span = 11.5;
//Calculate Amount of Support Triangles

$supportTriCount = max(ceil(($sysLengthIn / 12) / $span),2);	
$length =  ceil(($sysLengthIn/12)) ;
$supportTriCou = $length / $span;

//find cantilever

//echo "<br>";
$support = ceil($sysLengthft/ $span);
ceil($sysLengthft/ $span);
$spantotal = ($support - 1) * $span;

 $cantileverftpercent = ($sysLengthft - $spantotal) / $span / 2  ;

 $cantileverft =  $cantileverftpercent* $span;
$spanMM  = $span* 304.8;
 $cantileverMMr = $cantileverft * 304.8;
" cantilever " . $cantileverMM = round($cantileverMMr,1);
 //$cantileverMM = $cantileverft * 304.8;
//$cantileverMM;

//splice percentage 25%
$splicePerct = .25;
// potential rails

$crow1; $crow2; $crow3; $crow4; $crow5; $crow6; $crow7; $crow8;
$crow9; $crow10; $crow11; $crow12; $crow13; $crow14; $crow15; 

$railsrow2= array();
if ($support % 2 == 0) {
           $railsrow2[1] = $spanMM * (1 - $splicePerct * 2);
            $railsrow2[2] = $spanMM * ($splicePerct * 2) * 2 + $railsrow2[1];
            for ($i = 3; $i <= 15; $i++) {
                $railsrow2[$i] = round($spanMM * 2 + $railsrow2[$i - 2], 1);
            }
        } else {
            $railsrow2[1] = $spanMM * $splicePerct * 2;
           $railsrow2[2] = $spanMM * (1 - $splicePerct * 2) * 2 + $railsrow2[1];
            for ($i = 3; $i <= 15; $i++) {
                $percentage = $splicePerct* 2;
                if ($i % 2 == 0) {
                    $percentage = (1 - $splicePercentage * 2);
          }
        $railsrow2[$i] = $spanMM * $percentage * 2 + $railsrow2[$i - 1];
	 }
}



//echo '<pre>Redo Potential center rail ',print_r($railsrow2,1),'</pre>';
/*******get the potential center rails*******/
/******will need a rewrite to function******/

/********************************************************************************************************/
//echo '<pre>Potential center rail ',print_r($railsrow,1),'</pre>';
/************ Check *************************************************************************************/
// get the rail < 6200 from $railsrow
$railsMaxs = getMaxRail($railsrow2);


function getMaxRail($railsrow2){
$temprowMax = array();
foreach($railsrow2 as $key => $prows){
	
	if($prows <= 6200 ){
		 $temprowMax[$key] = $prows;	
	}		
}
return $temprowMax;
}

function getMaxRailVal($railsrow2, $val){
	$temprowMax = array();
foreach($railsrow2 as $key => $prows){
	
	if($prows < $val ){
		 $temprowMax[$key] = $prows;	
	}		
}
return $temprowMax;
	}
	
	

// max potential center
 $maxpotcenter =  max($railsMaxs);
 "max potential center " . $maxpotcenter;


$maxpot = getMaxRailVal($railsrow2, $maxpotcenter );
$checkmaxlessthanMaxcenter = max($maxpot);

 $checkmaxlessthanCheck2Max = getMaxRailVal($railsrow2, $checkmaxlessthanMaxcenter );
//echo print_r($checkmaxlessthanCheck2Max);
  $check2Max = max($checkmaxlessthanCheck2Max);
//get the highest rails key for center rials
getHighestKey($railsMaxs,1);

function getHighestKey($railsMaxs){
	$tempkey = array();
	foreach($railsMaxs as $key => $val){
	 	  $tempkey =  $key;	
	}
	//print_r(" row - " . substr($tempkey,3));
}

//get the highest key row
function getHighestKeyRow($railsMaxs){
	$tempkey = array();
	foreach($railsMaxs as $key => $val){
	 	  $tempkey =  $key;	
	}
	//print_r(" row - " .$tempkey);
}

/**
*  get the potential intermediate rail
*  calculate the potential intermediate rail  
*/

$potInterRails = array();
$tempPotInterRails = array();

 if ($support % 2 == 0) {
            $potInterRails[1] = $spanMM / 2;
        } else {
            $potInterRails[1] = $spanMM;
        }
        for ($i = 2; $i <= 15; $i++) {
            $potInterRails[$i] = $potInterRails[1] * $i;
        }
		
		
//echo '<pre>Potential intermediate rail ',print_r($potInterRails,1),'</pre>';

//get max intermediate rails
$IntermediateMaxs = getMaxRail($potInterRails);


//print_r($IntermediateMaxs);

//get the max value
  "Max potential Intermediate rail " . $maxIntermediate = max($IntermediateMaxs);

 "Min potential Intermediate rail " . $minIntermediate =  min($IntermediateMaxs);
/**
*  Get the Potential end rails
*
**/

$potEndRails = array();


$potEndRails[0] = round( $cantileverMM  + (1- $splicePerct) * $spanMM ,2);

for ($i = 1; $i <= 14; $i++) {
      if ($i % 2 == 0) {
               $potEndRails[$i] = round($potEndRails[$i - 1] + $spanMM * (1 - $splicePerct * 2), 2);
            } else {
                $potEndRails[$i] = round($potEndRails[$i - 1] + $spanMM * $splicePerct * 2, 2);
            }
        }



//echo "<pre>Potential End Rail" ,print_r($potEndRails),"</pre>";


//get max end rails

$EndMaxs = getMaxRail($potEndRails);
getHighestKeyRow($EndMaxs);
 " max end " . $EndRailMax =  max($EndMaxs);
			   $EndRailMin = min($EndMaxs);
			   
$stockLeng = 6200;
$stockLen = floatval($stockLeng);
$stockLenxx = 6200 * 2;
$stockLen2x= floatval($stockLenxx);

/*************************************< CHECK 1 >********************************************************/
//check potential center max
//echo print_r($EndMaxs);
"check 1 ideal mid rail " .$idealMidRailCheck1 = idealMidRail($maxpotcenter, $stockLen, $sysLength); 
 "check 1 rack remain from center " . $rackRemainFromCenterCheck1 = getRackRemainCenter($sysLength, $idealMidRailCheck1);
 "cantilever 75 " . $cantileverPlus75d = cantileverPlus75($cantileverMM , $spanMM);
$cantileverPlus75 = floatval(ceil($cantileverPlus75d));
//echo gettype($cantileverPlus75);
 "remain rail " . $remainingRails   = getRemainRails($rackRemainFromCenterCheck1, $IntermediateMaxs);
 $remainingRailsfl = floor($remainingRails);  

"check 1 end rail length ". $endRailCheck1d = getEndRailLength($remainingRails, $IntermediateMaxs);
 $endRailCheck1 = floatval(ceil($endRailCheck1d));
 //echo gettype($endRailCheck1);
 "check 1 end rail >= Cantilever + 75% - " . $check1 = checkCantilever($idealMidRailCheck1, $sysLength, $stockLen, $endRailCheck1, $cantileverPlus75 );
"check 1 Intermediate Rail count " . $check1IntermRailCountCheck1  = floor($remainingRails) * 2;
"check 1 end rail count ".  $endRailCountCheck1 = ceil($remainingRails - floor($remainingRails)) * 2;

/************************************</ CHECK 1  >********************************************************/

/************************************<  CHECK #2 >*******************************************************/
  "check 2 ideal mid rail " .$idealMidRailCheck2 = $checkmaxlessthanMaxcenter;
//idealMidRailCheck2($maxpotcenter, $stockLen, $sysLength, $rackRemainFromCenterCheck1);

 "check 2 rack remain from center " .$rackRemainCheck2  = getRackRemainCenter($sysLength, $idealMidRailCheck2);

$remainRailCheck2 = getRemainRails($rackRemainCheck2,$IntermediateMaxs);

 $endRailCheck2d = getEndRailLength($remainRailCheck2,$IntermediateMaxs);
"end rail length check 2 - " .  $endRailCheck2 = floatval(ceil($endRailCheck2d)) ;

 "check 2 end rail >= Cantilever + 75% - " .$check2 =  checkCantilever($idealMidRailCheck2, $sysLength, $stockLen, $endRailCheck2, $cantileverPlus75 );

 "check 2 Interm rail count ". $checkIntermRailCountChcek2  = floor($remainRailCheck2) * 2;

 "check 2 end rail count " . $endRailCountCheck2 = ceil($remainRailCheck2 - floor($remainRailCheck2)) * 2;

/***********************************</ CHECK #2 >*******************************************/

/*******************************  <    CHECK 3  > *******************************************/
 if($check2Max == 0 ){$idealMidRailCheck3 = 0;}else{$idealMidRailCheck3 = $check2Max;};
  "check 3 ideal mid rail " . $idealMidRailCheck3;
 //idealMidRailCheck2($idealMidRailCheck2, $stockLen, $sysLength, $crow1);

 "check 3 Rack Remain from center " . $rackRemainCheck3  = getRackRemainCenter($sysLength, $idealMidRailCheck3);

"check 3 remaining rails ". $remainRailCheck3 = getRemainRails($rackRemainCheck3,$IntermediateMaxs); 

 "check 3 End rail length " . $endRailCheck3 = getEndRailLength($remainRailCheck3,$IntermediateMaxs);

 "check 3 end rail >= Cantilever + 75% - " . $check3 = checkCantilever($idealMidRailCheck3, $sysLength, $stockLen, $endRailCheck3, $cantileverPlus75 );

 "check 3 Interm rail count ". $checkIntermRailCountChcek3 = floor($remainRailCheck3) * 2;

 "check 3 end rail count " . $endRailCountCheck3 = ceil($remainRailCheck3 - floor($remainRailCheck3)) * 2;

/******************************** </ CHECK #3 > *******************************************/
/**********************************< Check 4 >***********************************************/
 "check 4 ideal End Rail " .$idealEndRaild =  idealEndRail($EndRailMax, $stockLen, $sysLength);
$idealEndRail = floatval($idealEndRaild);
"check 4 end Rack remain from center " . $EndRackRemainCenter =  getEndRackRemainCenter($idealEndRail, $sysLength);

 //"check 4 remaining rails ". $remainRailCheck4 = getRemainRails($EndRackRemainCenter ,$maxIntermediate); 
"check 4 remaining rails ". $remainRailCheck4 = getRemainRails($EndRackRemainCenter ,$IntermediateMaxs); 
 "check 4 Interior rail length " .$InteriorRailCheck4 =  getInteriorRailLength($remainRailCheck4,$EndRackRemainCenter, $IntermediateMaxs);

 "check 4 ideal mid rail " . $idealMidRailCheck4 = idealMidRailCheck4($InteriorRailCheck4,$railsrow2);

"check 4 Interior Rail Length >= Ideal Mid Rail " . $check4 = InteriorRailLengGreaterIdealMidRail($idealMidRailCheck4,$InteriorRailCheck4, $stockLen , $idealEndRail);

 "check 4 Interm Rail Count " . $checkIntermRailCountCheck4 =  floor($remainRailCheck4) * 2;

  "check 4 End rail count " . $endRailCountCheck4 = ceil($remainRailCheck4 - floor($remainRailCheck4)) * 2;

/**********************************</ Check 4 >**********************************************/
/**********************************<  Check 5  >**********************************************/
"Check 5 Ideal End Rail " . $idealEndRailCheck5d = idealEndRail( idealEndRailCheck5($EndMaxs), $stockLen, $sysLength);
$idealEndRailCheck5 = floatval($idealEndRailCheck5d);
"Check 5 Rack remain from center " . $EndRackRemainCheck5d = getEndRackRemainCenter($idealEndRailCheck5,$sysLength);
$EndRackRemainCheck5 = floatval($EndRackRemainCheck5d);
"Check 5 remaining Rails " . $remainRailCheck5d =  getRemainRails($EndRackRemainCheck5 , $IntermediateMaxs);
$remainRailCheck5 = floatval($remainRailCheck5d);
"Check 5 Interior Rail Length " . $InteriorRailCheck5d =  getInteriorRailLength5($remainRailCheck5,$EndRackRemainCheck5, $IntermediateMaxs);
$InteriorRailCheck5 = floatval($InteriorRailCheck5d);
//echo  "Check 5 Ideal Mid Rail " . $idealMidRailCheck5d =  idealMidRailCheck4(floor($InteriorRailCheck5),floor($crow1));
"Check 5 Ideal Mid Rail " . $idealMidRailCheck5d =  idealMidRailcheck5($InteriorRailCheck5,$railsrow2);
$idealMidRailCheck5 = floatval($idealMidRailCheck5d);
"check 5 Interior Rail Length >= Ideal Mid Rail " . $check5 = InteriorRailLengGreaterIdealMidRail5( $idealMidRailCheck5,$InteriorRailCheck5 ,$stockLen, $idealEndRailCheck5);

 "check 5 Interm Rail Count " . $checkIntermRailCountCheck5 = floor($remainRailCheck5) * 2;

 "check 5 End rail count " . $endRailCountCheck5 = ceil($remainRailCheck5 - floor($remainRailCheck5)) * 2;

/**********************************</ Check 5 >**********************************************/
/**********************************< CHECK 6  >**************************/
"Check 6 Ideal End Rail "  . $idealEndRailCheck6d  = idealEndRail( $EndRailMin, $stockLen, $sysLength);
 $idealEndRailCheck6 = floatval($idealEndRailCheck6d );
 "Check 6 Rack remain from center " . $EndRackRemainCheck6 = getEndRackRemainCenterC6($idealEndRailCheck6,$sysLength); 
"Check 6 ideal remaining Rails " . $idealremainRailCheck6 =  getRemainRailsCheck6($stockLen , $minIntermediate);
"Check 6 remaining Rails " . $remainRailCheck6 =  getRemainRails678($EndRackRemainCheck6 , $idealremainRailCheck6);
//$IntermediateMaxs //$remainRailCheck6
 "Check 6 Interior Rail Length " . $InteriorRailCheck6d =  getInteriorRailLength6( $idealremainRailCheck6, $EndRackRemainCheck6,$remainRailCheck6 );
 $InteriorRailCheck6 = floatval($InteriorRailCheck6d);
//$maxpotcenter6  = floatval($crow1);  //idealMidRailcheck6($InteriorRailCheck4,  $tmpRailArr)
 "Check 6 Ideal Mid Rail " . $idealMidRailCheck6d =  idealMidRailcheck6($InteriorRailCheck6,$railsrow2);
 $idealMidRailCheck6= floatval($idealMidRailCheck6d);
 "check 6 Interior Rail Length >= Ideal Mid Rail " . $check6 =  InteriorRailLengGreaterIdealMidRail( $idealMidRailCheck6,$InteriorRailCheck6 ,$stockLen,  $idealEndRailCheck6);
"check 6 Interm Rail Count " . $check1IntermRailCountCheck6 = floor($remainRailCheck6) * 2;
"check 6 End rail count " . $endRailCountCheck6 = ceil($remainRailCheck6 - floor($remainRailCheck6)) * 2;

/*********************************************</ CHECK 6 >*******************************************/
/*********************************************</ CHECK 7  >******************************************/
"Check 7 Ideal End Rail "  . $idealEndRailCheck7 = idealEndRail( $EndRailMax, $stockLen, $sysLength);
"Check 7 Rack remain from center " . $EndRackRemainCheck7 = getEndRackRemainCenterC6($idealEndRailCheck7,$sysLength); 

"Check 7 ideal remaining Rails " . $idealremainRailCheck7 =  getRemainRailsCheck6($stockLen , $maxIntermediate);
"Check 7 remaining Rails " . $remainRailCheck7 =  getRemainRails678($EndRackRemainCheck7 , $idealremainRailCheck7);
"Check 7 Interior Rail Length " . $InteriorRailCheck7 =  getInteriorRailLength( $remainRailCheck7 , $EndRackRemainCheck7, $IntermediateMaxs);
"Check 7 Ideal Mid Rail " . $idealMidRailCheck7 =  idealMidRailCheck4($InteriorRailCheck7,$railsrow2);
"check 7 Interior Rail Length >= Ideal Mid Rail " . $check7 = InteriorRailLengGreaterIdealMidRail( $idealMidRailCheck7,$InteriorRailCheck7 ,$stockLen, $idealEndRailCheck7);
"check 7 Interm Rail Count " . $checkIntermRailCountCheck7 =  floor($remainRailCheck7) * 2;
"check 7 End rail count " . $endRailCountCheck7 = ceil($remainRailCheck7 - floor($remainRailCheck7)) * 2;

/*****************************</ CHECK 7 >******************************************/

/***************************** < CHECK 8 >******************************************/
"Check 8 Ideal End Rail "  . $idealEndRailCheck8 = idealEndRail($EndRailMax, $stockLen, $sysLength);
 
"Check 8 Rack remain from center " . $EndRackRemainCheck8 = getEndRackRemainCenterC6($idealEndRailCheck8,$sysLength); 

  "Check 8 ideal remaining Rails length" .   $idealremainRailCheck8 =  getRemainRailsCheck6($stockLen ,$potInterRails[2]);

  $remainRailCheck8 =  getRemainRails8($EndRackRemainCheck8 , $idealremainRailCheck8);
if($remainRailCheck8 == 0.0 ) {   0;}else{   $remainRailCheck8;} 

"Check 8 Interior Rail Length " . $InteriorRailCheck8 =  getInteriorRailLength6( $idealremainRailCheck8 , $EndRackRemainCheck8,$remainRailCheck8);

"Check 8 Ideal Mid Rail " . $idealMidRailCheck8 =  idealMidRailCheck4($InteriorRailCheck8,$railsrow2);

"check 8 Interior Rail Length >= Ideal Mid Rail " . $check8 = InteriorRailLengGreaterIdealMidRail( $idealMidRailCheck8,$InteriorRailCheck8 ,$stockLen, $idealEndRailCheck8);
 
"check 8 Interm Rail Count " . $checkIntermRailCountCheck8 = floor($remainRailCheck8) * 2;

"check 8 End rail Count " . $endRailCountCheck8 =  ceil($remainRailCheck8 - floor($remainRailCheck8)) * 2;

/******************************</ CHECK 8 >****************************************/

 /******************************< CHECK 9  >****************************************/
"Check 9 Ideal End Rail "  . $idealEndRailCheck9 = idealEndRail($EndRailMax, $stockLen, $sysLength);

 "Check 9 Rack remain from center " . $EndRackRemainCheck9 = getEndRackRemainCenterC6($idealEndRailCheck9,$sysLength); 

 "Check 9 ideal remaining Rails " .   $idealremainRailCheck9 =  getRemainRailsCheck6($stockLen , idealEndRailCheck5($IntermediateMaxs));

 $remainRailCheck9 =  getRemainRails678($EndRackRemainCheck9 , $idealremainRailCheck9);
if($remainRailCheck9 == 0.0 ) {   0;}else{   $remainRailCheck9;} 

 "Check 9 Interior Rail Length " . $InteriorRailCheck9 =  getInteriorRailLength6( $idealremainRailCheck9 , $EndRackRemainCheck9, $remainRailCheck9);

 "Check 9 Ideal Mid Rail " . $idealMidRailCheck9 =  idealMidRailCheck4($InteriorRailCheck9,$railsrow2);

 "check 9 Interior Rail Length >= Ideal Mid Rail " . $check9 =  InteriorRailLengGreaterIdealMidRail( $idealMidRailCheck9,$InteriorRailCheck9 ,$stockLen, $idealEndRailCheck9);

 "check 9 Interm Rail Count " . $checkIntermRailCountCheck9 =  floor($remainRailCheck9) * 2;

 "check 9 End rail Count " . $endRailCountCheck9 = ceil($remainRailCheck9 - floor($remainRailCheck9)) * 2;

 /*****************************<  CHECK 9   >*****************************************/
 
 /***************************** CHECK ARRAY ******************************************/

/*****************************<  CHECK 10  >*****************************************/

  //echo "End Potential Max " . print_r($potEndRails,1);

  //"20317  <= 12400";
 "Check 10 Ideal Iterm Rail "  . $idealEndRailCheck10d = idealEndRail($EndRailMax, $stockLen, $sysLength);
 $idealEndRailCheck10 = floatval($idealEndRailCheck10d);
 $idealIntermRailCheck10arr         =  getMaxRail($potEndRails);
 $idealIntermRailCheck10d           =  idealEndRailCheck5($idealIntermRailCheck10arr);
 $idealIntermRailCheck10 	        =  floatval($idealIntermRailCheck10d);
 $idealIntermRalCh10d        	    =  idealEndRailCheckfirsthigh($idealIntermRailCheck10arr);
 $idealIntermRalCh10                =  ceil(floatval($idealIntermRalCh10d));
 $idealIntermRailCheck10trail3d     =  idealEndRailCheck6($idealIntermRailCheck10arr);
 //$idealIntermRailCheck10trail3d =   idealEndRailCheckfirsthigh($idealIntermRailCheck10arr);
 $idealIntermRailCheck10trail3      =  ceil(floatval($idealIntermRailCheck10trail3d));
 $idealIntermRailCheck10trail4d     =  idealEndRailChecktrail($idealIntermRailCheck10arr);
 $idealIntermRailCheck10trail4      =  floatval($idealIntermRailCheck10trail4d);

 
 "Check 10 Rack remain from Center " . $EndRackRemainCheck10 = getEndRackRemainCenterC6($idealEndRailCheck10,$sysLength); 
 "Check 10 Ideal Rack remain Center Trail 1 " . $idealRackRemainCenter10d =   $sysLength  - abs($idealEndRailCheck10);
 "Check 10 Ideal Rack remain Center Trail 2 " . $trail2d = $sysLength - $idealIntermRailCheck10 ;
 "Check 10 Ideal Rack remain Center Trail 3 " . $trail3d =  $sysLength - $idealIntermRailCheck10trail3;
 "Check 10 Ideal Rack remain Center Trail 4 " . $trail4d =  $sysLength - $idealIntermRailCheck10trail4;

//final Check 10 
 $rSet = finalCheck10($stockLen, $sysLength, $potEndRails);
 
 //echo "<pre>",print_r($rSet),"</pre>";
 if($rSet["checkPassed"]){
 	$trailtest = "true";
	
 }else{$trailtest = "false";}
 
function finalCheck10($stockLen, $sysLength, $potEndRails){
	$railSet = array();
	 $checkPassed = false;
$trials = array(
            'idealRail' => array(),
            'rackRemainderFromCenter' => array(),
            'checkPassed' => array(),
        );
		
for ($i = 1; $i <= 4; $i++) {
             $idealRail = getIdealRail($potEndRails,$stockLen, $sysLength, $i - 1);
            $rackRemainderFromCenter = $sysLength - $idealRail;
            $checkPassed = in_array(round($rackRemainderFromCenter, 2), $potEndRails) &&
                ($sysLength <= ($stockLen * 2)) && ($rackRemainderFromCenter <= $stockLen);
            if ($checkPassed) {
                $trials['idealRail'][$i] = $idealRail;
                $trials['rackRemainderFromCenter'][$i] = $rackRemainderFromCenter;
                $trials['checkPassed'][$i] = $checkPassed;
            }
     }	

 		$railSet["centerRailLength"] = 0;
        $railSet["intermediateRailLength"]= 0;
        $railSet["intermediateRailCount"] = 0;
        $railSet["endRailLength"] = 0;
        $railSet["endRailCount"] = 0;
        $railSet["checkPassed"] = false;
		
		
        if (!empty($trials['rackRemainderFromCenter'])) {
            $trialNumbers = array_keys($trials['rackRemainderFromCenter']);
            $firstTrial = $trialNumbers[0];            
            $railSet["centerRailLength"]  = $trials['rackRemainderFromCenter'][$firstTrial];
            $railSet["intermediateRailLength"] = $trials['idealRail'][$firstTrial];
            if ( $railSet["intermediateRailLength"]) {
                $railSet["intermediateRailCount"] = 1;
            }
            if ($railSet["intermediateRailLength"]<= $stockLen) {
                 $railSet["checkPassed"] = true;   
            }
        }
		
		return $railSet;
	}	
		
		
 function getIdealRail($potEndRails,$stockLen, $sysLength, $previous = 0, $max = null)
    {
        $idealRail = 0;
        /*if ($systemLength <= $stockRail) {
            $idealRail = $systemLength;
        } else {*/
            $possibleRails = array_filter($potEndRails, function($rail) use ($stockLen) {
                return $rail <= $stockLen;
            });
			
            $idealRail = end($possibleRails);
            if ($previous > 0) {
                for ($i = 1; $i <= $previous; $i++) {
                    $idealRail = prev($possibleRails);
                }
                if ($max) {
                    while ($idealRail >= $max) {
                        $idealRail = prev($possibleRails);
                        if (false === $idealRail) {
                            break;   
                        }
                    } 
                }
            } elseif ($previous < 0) {
                $idealRail = reset($possibleRails);
                if ($previous < -1) {
                    for ($i = -2; $i >= $previous; $i--) {
                        $idealRail = next($possibleRails);
                    }
                }
            }
            // We're out of rails. e.g., Calculations!C56 
            if (false === $idealRail) {
                $idealRail = 0;   
            }
        //}
        //echo "<pre>",$stockLen,"</pre>";
		//echo "<pre>",print_r($possibleRails),"</pre>";
        return $idealRail;
    }


//"check10" => array($idealRackRemainCenter10,$IntermediateRailCountCheck10,$IntermediateRailLengthCheck10,0,0,$trailtest )
/*****************************</ CHECK 10 >*******************************************/	
//Check table
$checkArr = array(
		"1" => array("centerRailLength" => $idealMidRailCheck1, "intermediateRailCount" => $check1IntermRailCountCheck1, "intermediateRailLength" => $maxIntermediate
		,"endRailCount" => $endRailCountCheck1,"endRailLength" =>$endRailCheck1,"checkPassed" => $check1),
		"2" => array("centerRailLength" =>$idealMidRailCheck2,"intermediateRailCount" => $checkIntermRailCountChcek2,"intermediateRailLength" => $maxIntermediate
		, "endRailCount" => $endRailCountCheck2, "endRailLength" => $endRailCheck2, "checkPassed" =>$check2),
		"3" => array("centerRailLength" => $idealMidRailCheck3, "intermediateRailCount" =>$checkIntermRailCountChcek3, "intermediateRailLength" => $maxIntermediate
		, "endRailCount" => $endRailCountCheck3, "endRailLength" => $endRailCheck3, "checkPassed" =>$check3 ),
		"4" => array("centerRailLength" => $InteriorRailCheck4, "intermediateRailCount" =>$checkIntermRailCountCheck4, "intermediateRailLength" => $maxIntermediate
		,"endRailCount" => $endRailCountCheck4, "endRailLength" => $idealEndRail, "checkPassed" => $check4),
		"5" => array("centerRailLength" => $InteriorRailCheck5,"intermediateRailCount" => $checkIntermRailCountCheck5, "intermediateRailLength" => $maxIntermediate
		, "endRailCount"=> $endRailCountCheck5,"endRailLength" => $idealEndRailCheck5, "checkPassed" => $check5 ),
		"6" => array("centerRailLength" => $InteriorRailCheck6, "intermediateRailCount" =>$check1IntermRailCountCheck6, "intermediateRailLength" => $idealremainRailCheck6
		,"endRailCount" => $endRailCountCheck6,"endRailLength" => $idealEndRailCheck6,"checkPassed" => $check6),
		"7" => array("centerRailLength"  => $InteriorRailCheck7, "intermediateRailCount" => $checkIntermRailCountCheck7,"intermediateRailLength" =>$idealremainRailCheck7
		,"endRailCount"=>  $endRailCountCheck7,"endRailLength" => $idealEndRailCheck7, "checkPassed" =>$check7),
		"8" => array("centerRailLength" => $InteriorRailCheck8, "intermediateRailCount" => $checkIntermRailCountCheck8, "intermediateRailLength" => $idealremainRailCheck8
		,"endRailCount" => $endRailCountCheck8, "endRailLength" => $idealEndRailCheck8, "checkPassed" => $check8),
		"9" => array("centerRailLength" => $InteriorRailCheck9, "intermediateRailCount" =>$checkIntermRailCountCheck9,"intermediateRailLength" => $idealremainRailCheck9
		,"endRailCount"=> $endRailCountCheck9,"endRailLength"=>$idealEndRailCheck9,"checkPassed"=> $check9),
		"10" => array("centerRailLength" => $idealRackRemainCenter10,"intermediateRailCount" => $IntermediateRailCountCheck10, "intermediateRailLength" =>$IntermediateRailLengthCheck10
		,"endRailCount"=> 0,"endRailLength"=> 0,"checkPassed" => $trailtest)
);

//check 10 Interm rail count
function  getIntermRailCount($trailtest , $IntermediateRailCountCheck10){
if($rSet["checkPassed"]){
	return	$IntermediateRailCountCheck10;
}else{}
}

//$lowEnd = min(array_filter($min2));
//get the lowest variation column
//$lowestRailLenCut = array();

$RailLenCut = array();
foreach($checkArr as $k => $checks ){
	foreach($checks as $key => $val){
	if( $checks[5] == "true" ){
	  $lowestRailLenCut[] = $val ;
	  $RailLenCut[$k][$key] = $val ;
		}elseif($checks[5] == "false"){
		 // $lowestRailLenCut[] = $val ;
		 // $RailLenCut[$k][$key] = $val ;
		}
	}
		
}

//Get the min of Intermediate and End Columns 
$min1 = array();
$min2 = array();
foreach($RailLenCut as $kk => $ch){
$min1[$kk] = $ch[1];
$min2[$kk] = $ch[3];
}
//$lowInterm = min($min1);
if($rSet["checkPassed"]){
	$lowInterm = $IntermediateRailCountCheck10;
}else{  
	$lowInterm = min($min1);
}


$lowestRailLenCut = array();
foreach($RailLenCut as $k => $c ){
	foreach($c as $key => $val){
	  if( $c[1] == $lowInterm ){
	  $lowestRailLenCut[] = $val;
	  //$RailLenCut[$k][$key] = $val;
	 }
	}
}

//echo "<pre>",print_r( $checkArr,1),"</pre>";

/****************************  Calculator  ***************************************/
$center = "";
$IntermediateRailCut ="";
$cuttingstock = array();
$bestresults = array_fill_keys(
array('centerRailLength', 'centerRailCount','intermediateRailLength', 'intermediateRailCount', 'endRailLength', 'endRailCount','checkPassed'), '');
//echo  $rSet["checkPassed"];
// rail cut table calculation
if($rSet["checkPassed"]){
	//echo "checkpassed";
	$center =  $rSet["centerRailLength"];
	$IntermediateRailCut = $rSet["intermediateRailLength"];
	$IntermediateRailRow = 1;
	$EndRailCut = 0;
	$EndRailRow = 0;
	$RailColumnTF = $rSet["checkPassed"];
	
	$bestresults["centerRailLength"] = $center;
	$bestresults["intermediateRailLength"]=$IntermediateRailCut;
	$bestresults["intermediateRailCount"] = $IntermediateRailRow;
	$bestresults["endRailLength"] = 0;
	$bestresults["endRailCount"] = 0;
	$bestresults["checkPassed"] = $RailColumnTF;
	
	$bestRailSet = $bestresults;
	
}else{
	
	$railCheck = 1;	
	//get all true checks
	 $railSetChoices = array_filter($checkArr, function($railCheck) {
               return $railCheck["checkPassed"] == "true"; 
     });	
     
	//echo "<pre>",print_r(  $railSetChoices ,1),"</pre>";	
	 $minIntermediateRailCount = null;
            foreach ($railSetChoices as $railSetChoice) {
                if (null === $minIntermediateRailCount) {
                    $minIntermediateRailCount = $railSetChoice["intermediateRailCount"];
                } elseif ($railSetChoice["intermediateRailCount"] < $minIntermediateRailCount) {
                    $minIntermediateRailCount = $railSetChoice["intermediateRailCount"];
                }
            }

       // Filter to those choice that match the minimum and keep the key order.
      $railSetChoices = array_filter($railSetChoices, function($railSetChoice) use ($minIntermediateRailCount) {
               return $railSetChoice["intermediateRailCount"] === $minIntermediateRailCount;
      });

     $bestRailSet = reset($railSetChoices);
	 $center =  $bestRailSet["centerRailLength"];
	 $IntermediateRailCut = $bestRailSet["intermediateRailLength"];
	 $IntermediateRailRow = $bestRailSet["intermediateRailCount"];
	 $RailColumnTF  = $bestRailSet["checkPassed"];
	 $EndRailCut = $bestRailSet["endRailLength"];
	 $EndRailRow  = $bestRailSet["endRailCount"];
	 
	  $bestresults["centerRailLength"] = $center;
	 $bestresults["intermediateRailLength"]=$IntermediateRailCut;
	 $bestresults["intermediateRailCount"] = $IntermediateRailRow;
	 $bestresults["endRailLength"] =  $EndRailCut;
	 $bestresults["endRailCount"] =$EndRailRow ;
	 $bestresults["checkPassed"] = $RailColumnTF;
    // $bestRailSet = $bestresults;

}

 	//check Intermediate row
	$IntermediateCheck = $sysLength - $tolerance;

	if ($RailColumnTF || $supportTriCount == 2) {
		$centerrowcount = 1;
		$bestresults["centerRailCount"] = $centerrowcount;
	} else {
		 $centerrowcount = 0;
		 $bestresults["centerRailCount"] = $centerrowcount;
	};
	
	
	
	
	       if ($supportTriCount == 2 && $sysLength >  $stockLen) {
            $IntermediateRailRow = 1;
        $bestresults["intermediateRailCount"] = $IntermediateRailRow;
        } elseif ($supportTriCount == 2 && $sysLength <= $stockLen) {
          $IntermediateRailRow = 0;
        $bestresults["intermediateRailCount"] = $IntermediateRailRow;
        } elseif ($bestresults["checkPassed"]) {
            $bestresults["intermediateRailCount"] = $IntermediateRailRow;
        }
     
	
	  if ($support == 2) {
		$EndRailRow = 0;
		$bestresults["endRailCount"] = $EndRailRow ;
	} elseif ($RailColumnTF ) {
		 $EndRailRow;
		 $bestresults["endRailCount"] =$EndRailRow ;
	} else {
		$EndRailRow = 0;
		$bestresults["endRailCount"] =$EndRailRow ;
	}
	
	  
	// One span rail call	
	$onespanrail = onespanrail( $cantileverMM , $spanMM , $sysLength);	
	
	//echo "<pre>",print_r($onespanrail[1]),"</pre>";
    
	  if ($sysLength<= $stockLen) {
            $bestresults['centerRailLength'] = $sysLength;
        } elseif ($supportTriCount == 2 && $sysLength > $stockLen) {
            $bestresults['centerRailLength'] = round($onespanrail[0],-1);
        } elseif ($supportTriCount == 2 && $sysLength <= $stockLen) {
            $bestresults['centerRailLength'] = $this->parameters['systemLength'];
        } elseif ($bestRailSet["checkPassed"]) {
            $bestresults['centerRailLength'] = $bestRailSet["centerRailLength"];
        }
	  
    
	  if ($sysLength <= $stockLen ){
            $bestresults['intermediateRailLength'] = 0;
            $bestresults['intermediateRailCount'] = 0;
        } elseif ($bestresults['intermediateRailCount'] === 0) {
            $bestresults['intermediateRailLength'] = 0;
        } elseif ($supportTriCount == 2 && $sysLength > $stockLen) {
            $bestresults['intermediateRailLength'] = round($onespanrail[1],-1);
        } elseif ($supportTriCount == 2 && $sysLength <= $stockLen) {
            $bestresults['intermediateRailLength'] = 0;
            $bestresults['intermediateRailCount'] = 0;
        } elseif ($bestresults["checkPassed"]) {
            $bestresults['intermediateRailLength'] = $bestRailSet["intermediateRailLength"];
        } else {
            $bestresults['intermediateRailLength'] = 0;
            $bestresults['intermediateRailCount'] = 0;
        }
	
	   // echo "<pre>",print_r($bestresults ,1),"</pre>";
	
		if ($sysLength <= $stockLen) {
            $bestresults['endRailLength'] = 0;
            $bestresults['endRailCount'] = 0;
        } elseif (2 === $supportCount) {
            $bestresults['endRailLength'] = 0;
            $bestresults['endRailCount'] = 0;
        } elseif ($bestresults["checkPassed"]) {
            $bestresults['endRailLength'] = $bestRailSet["endRailLength"];
        } else {
            $results['endRailLength'] = 0;
            $results['endRailCount'] = 0;
        }
		
		
	$totalQtyRails = array();
	if($isLandscape){
		$totalQtyRails["centerTotal"] = $bestresults["centerRailCount"] * $moduleRow +1;
		$totalQtyRails["intermediateTotal"] = $bestresults["intermediateRailCount"] * $moduleRow +1;
		$totalQtyRails["endTotal"] = $bestresults["endRailCount"] * $moduleRow + 1;
		
	}else{
		
		$totalQtyRails["centerTotal"] = $bestresults["centerRailCount"] * $moduleRow *2;
		$totalQtyRails["intermediateTotal"] = $bestresults["intermediateRailCount"] * $moduleRow *2;
		$totalQtyRails["endTotal"] = $bestresults["endRailCount"] * $moduleRow * 2;
		
	}
		
	// Total Rails Row	
    $bestresults["totalRailRow"] = $bestresults["centerRailCount"] + $bestresults["intermediateRailCount"] + $bestresults["endRailCount"] ;
		
		
	$stocksize = array(1 => $maxRail , 2=> $maxRail , 3=>$minRail , 4=> $minRail, 5=> $minRail );	
	$requireRail = array("center" => $bestresults["centerRailLength"]  , "intermediate" => $bestresults["intermediateRailLength"], "end" => $bestresults["endRailLength"]);
	 
	
	$spliceCountTotal = (($bestresults["totalRailRow"] ) - 1) * ($moduleRow *2);
	$bestresults["spliceCount"] = $spliceCountTotal;
	
		
	//echo "<pre>",print_r($requireRail),"</pre>";
	//echo "<pre>",print_r($totalQtyRails),"</pre>";
	
	$stocktem = StockCut($stocksize, $requireRail, $totalQtyRails);
	
	$optimalRails = new MostEfficentRail($requireRail);
	
	//echo "<pre>",print_r($stocktem),"</pre>";
	//echo "<pre>",print_r($optimalRails),"</pre>";
	
	
	$combinationmatrix1 = $optimalRails->optimal1($requireRail);
	$combinationmatrix2 = $optimalRails->optimal2($requireRail);
	$combinationmatrix3 = $optimalRails->optimal3($requireRail);
	$combinationmatrix4 = $optimalRails->optimal4($requireRail);
	$combinationmatrix5 = $optimalRails->optimal5($requireRail);
	
	$railResults= array();
	$railResults['stock'] = $stocktem;
	$railResults[1] = getMostEfficientRails($stocksize, $requireRail, $totalQtyRails, $combinationmatrix1,$stocktem, $stockRail =1);
	$railResults[2] = getMostEfficientRails($stocksize, $requireRail, $totalQtyRails, $combinationmatrix2,$stocktem, $stockRail =2);
	$railResults[3] = getMostEfficientRails($stocksize, $requireRail, $totalQtyRails, $combinationmatrix3,$stocktem, $stockRail =3);
	$railResults[4] = getMostEfficientRails($stocksize, $requireRail, $totalQtyRails, $combinationmatrix4,$stocktem, $stockRail =4);
	$railResults[5] = getMostEfficientRails($stocksize, $requireRail, $totalQtyRails, $combinationmatrix5,$stocktem, $stockRail =5);
	
	
	$fewestRails = array();
    $fewestRails['stock'] = $railResults['stock']['totalShippingLength'];
    $fewestRails[1] = $railResults[1]['totalShippingLength'];
    $fewestRails[2] = $railResults[2]['totalShippingLength'];
    $fewestRails[3] = $railResults[3]['totalShippingLength'];
    $fewestRails[4] = $railResults[4]['totalShippingLength'];
    $fewestRails[5] = $railResults[5]['totalShippingLength'];
        
    $mostEfficientLength = min($fewestRails);
    $mostEfficientCut = array_search($mostEfficientLength, $fewestRails);
     	
	//echo $stockLen;
	//echo $supportTriCount;
	if ( max($bestresults['centerRailLength'], $bestresults['intermediateRailLength'], $bestresults['endRailLength']) > $stockLen ||
            $bestresults['centerRailLength'] == 0 ||
            ($supportTriCount <= 2 && $onespanrail[0] > $stockLen)
        ) {
           $confirmation = 'Custom rail is required';
        } else {
           $railLengthPerRow = $bestresults['centerRailCount'] * $bestresults['centerRailLength'] + $bestresults['intermediateRailCount'] * $bestresults['intermediateRailLength'] + 
            $bestresults['endRailCount'] * $bestresults['endRailLength'];
            $difference = $railLengthPerRow - $sysLength;
            $toleranceOK = abs($difference) < $tolerance;		
			
            if ($toleranceOK) {
                $confirmation = "Confirmed ({$difference}mm)";
            } else {
                $overage = abs($difference) - $tolerance;
                $confirmation = "Out of Spec ({$overage}mm)";
            }
        }
		
	  	$bestresults['railsShipping'] = $railResults[$mostEfficientCut]['railsShipping'];
      	//$bestresults['spliceCount'] = $spliceCount;
        $bestresults['confirmation'] = $confirmation;
        $bestresults['stockRailQuantity'] = $railResults[$mostEfficientCut]['stockRailQuantity'];
        
        // Instructions
         $result = $railResults[$mostEfficientCut];
        $wastePercentage = $result['wastePercentage'] * 100;
        $wasteInstructions = "with {$wastePercentage}% [{$result['wasteLength']}mm] of {$result['totalShippingLength']}mm wasted";
        $bestresults['instructions'] = $railResults[$mostEfficientCut]['instructions'];
        //$bestresults['instructions'][5] = $wasteInstructions;
        	
			
       
	 // echo "<pre>",print_r(  $result),"</pre>";  
	/************************** Get the Stock Cut ******************************/	
	
 	function StockCut($stocksize, $requireRail, $totalQtyRails){
		$temparray = array();
		
		$totalRequiredLength = 0;
        foreach ($requireRail as $position => $length) {
            $totalRequiredLength += $length * $totalQtyRails[$position."Total"];
        }
        		
		$finalsum = 0;	
		$finalsumRail = 0;				
		foreach($requireRail as $pos => $railLen){				
			$temparray[$pos] = array();
			foreach ($stocksize as $railsize => $size) {				
				if($size == 0){
				$quantity= 0;
				}else{
				$quantity = floor($size / $railLen);	
				}							
				$temparray[$pos][$railsize] =array(
                    'quantity' => $quantity,
                    'percentage' => round(($quantity * $railLen) / $size, 2),
                    'stockRail' => $size,
                );					
			}
			
			$temparr = $temparray[$pos];
			 uasort($temparr, function($a, $b) {
                if ($a['percentage'] == $b['percentage']) {
                    return 0;
                } elseif ($a['percentage'] < $b['percentage']) {
                    return -1;
                } else {
                    return 1;
                }
            });
			
			$bestChoice = array_pop($temparr);
			$temparray[$pos]["choose"] = $bestChoice["stockRail"];
			$temparray[$pos]["fromStock"] = $bestChoice["quantity"];
			
			if($bestChoice["quantity"] == 0){
				$temparray[$pos]["stockPercentage"] = 0;
			}else{				
				$temparray[$pos]["stockPercentage"] = 1 / $bestChoice["quantity"];
			}
			
 			$temparray[$pos]["finalQty"] = ceil( $temparray[$pos]["stockPercentage"] * $totalQtyRails[$pos."Total"]);
			$finalsum = $finalsum + $temparray[$pos]["finalQty"];
			$finalsumRail = $finalsumRail + $bestChoice["stockRail"] * $temparray[$pos]["finalQty"];
					
		}

		//echo "<pre>",print_r($bestChoice["quantity"]),"</pre>";
 		$wasteLength = $finalsumRail  - $totalRequiredLength;
       
        $fromStock = array();
        $choose = array();
        foreach ($temparray as $position => $value) {
            $fromStock[$position] = $value['fromStock'];
            $choose[$position] = $value['choose'];
        }
        
        $stockRailQuantity = array();
        foreach ($stocksize as $rail) {
            // Duplicate keys OK here.
            $stockRailQuantity[$rail] = 0;
        }
        
        $instructions = array(1 => '');
        $line = 2;
        foreach ($requireRail as $position => $length) {
            $cuts = $temparray[$position]['fromStock'] * $temparray[$position]['finalQty'];
            //echo "<pre>",$cuts,"</pre>";
            if (0 == $cuts) {
                $instructions[$line] = '';
            } else {
                $instructions[$line] = "Cut ({$cuts}) {$length}mm rail(s) from".
                    " ({$temparray[$position]['finalQty']})".
                    " {$temparray[$position]['choose']}mm stock rails.";
            }
            $line++;
            $stockRailQuantity[$temparray[$position]['choose']] += $temparray[$position]['finalQty'];
        }						
		//echo "<pre>",print_r($temparray ),"</pre>";
		return array(
            'railsShipping' => (int) $finalsum,
            'totalShippingLength' => (int) $finalsumRail,
            'wasteLength' => (int) $wasteLength,
            'wastePercentage' => round($wasteLength / $totalRequiredLength, 4),
            'fromStock' => $fromStock,
            'choose' => $choose,
            'totalRequiredLength' => $totalRequiredLength,
            'instructions' => $instructions, 
            'stockRailQuantity' => $stockRailQuantity,
        );
	}

	//Most Eff rails
   function getMostEfficientRails($stocksize, $requireRail, $totalQtyRails, $combomatrix,$stocktem,$stockRail) 
    {
        $railCombinationMatrix = $combomatrix;

		//echo "<pre>",print_r($railCombinationMatrix),"</pre>";
		
        $optimalLength = array();
        foreach ($railCombinationMatrix as $key => $combination) {
            $totalLength = 0;
            foreach ($combination as $subKey => $count) {
                list($position, $length) = explode('-', $subKey);
                $totalLength += $length * $count; 
            }
            $optimalLength[$key] = $totalLength;
        }
				
        // Get the combination that has a total length closest to but less than the stockRail
        $optimalKey = null;
        $stockRails = $stocksize;
        $previousLength = 0;
        foreach ($optimalLength as $key => $length) {
        	//echo $stockRail;
            if ($length <= $stockRails[$stockRail] && $length > $previousLength) {
                $optimalKey = $key;
                $previousLength = $length;
            }
        }
      	    	
        $requiredRails = $requireRail;
		
        $optimalCombination = array(
            'center-'.$requiredRails['center'] => 0,
            'intermediate-'.$requiredRails['intermediate'] => 0,
            'end-'.$requiredRails['end'] => 0,
        );
		
		
        $requiredQuantities = $totalQtyRails;
		 $requiredQuantitiesUse = array(
            'center' => $requiredQuantities["centerTotal"],
            'intermediate' => $requiredQuantities["intermediateTotal"],
            'end' => $requiredQuantities["endTotal"],
        );
		//echo "<pre>required quantities",print_r($requiredQuantitiesUse ),"</pre>";		
				
        if (null !== $optimalKey) {
            $optimalCombination = $railCombinationMatrix[$optimalKey];
           
		    /*foreach ($optimalCombination as $key => $count) {
                if (!$count) {
                    list($position, $length) = explode('-', $key);
                    unset($requiredQuantities[$position]);
                }
            } */
            
        }

        $used = array(
            'center' => 0,
            'intermediate' => 0,
            'end' => 0,
        );
		
     	$usedTemp = array();
        foreach ($requiredQuantitiesUse as $position => $count) {
            if (0 !== $optimalCombination[$position.'-'.$requiredRails[$position]]) {
                $usedTemp[$position] = $requiredQuantitiesUse[$position] / $optimalCombination[$position.'-'.$requiredRails[$position]];
            }
        }
        		
		//echo "<pre>",print_r($optimalCombination),"</pre>";
        if (!empty($usedTemp)) {
            foreach ($used as $position => $quantity) {
                $used[$position] = min($usedTemp);
            }
        }
        $usedMax = max($used);
		
				        
         $remainingRails = array();
      //  $realRequiredQuantities = $totalQtyRails;
		$realRequiredQuantities  = $requiredQuantitiesUse;
        foreach ($realRequiredQuantities as $position => $count) {
            $remainingRails[$position] = $realRequiredQuantities[$position] - $used[$position] * $optimalCombination[$position.'-'.$requiredRails[$position]];
        }
		
		//echo "<pre>",print_r($optimalCombination),"</pre>";
                        
       $mostEfficientStockRails = $stocktem;
		
        $fromStock = $mostEfficientStockRails['fromStock'];
        
        $fullSections = array();
        foreach ($remainingRails as $position => $count) {
            if (0 === $fromStock[$position]) {
                $fullSections[$position] = 0;
            } else {
                $fullSections[$position] = ceil($count / (float) $fromStock[$position]);
            }
        }
        		
        $fullSectionsTotal = array_sum($fullSections);

        $railsShipping = (int) $usedMax + (int) $fullSectionsTotal;
        
        $totalShippingLength = $usedMax * $stockRails[$stockRail] +
            $fullSections['center'] * $mostEfficientStockRails['choose']['center'] +
            $fullSections['intermediate'] * $mostEfficientStockRails['choose']['intermediate'] +
            $fullSections['end'] * $mostEfficientStockRails['choose']['end']
        ;
        
        $totalShippingLength = (int) $totalShippingLength;
        $wasteLength = $totalShippingLength - $mostEfficientStockRails['totalRequiredLength'];
        $wastePercentage = round($wasteLength / $totalShippingLength, 2);

        // Instructions
         $instructions = array(
            1 => '',
            2 => '',
            3 => '',
            4 => '',                                    
        );
        $stockRailQuantity = array();
        foreach ($stockRails as $rail) {
            // Duplicate keys OK here.
            $stockRailQuantity[$rail] = 0;
        }
        if (0 === $usedMax) {
            ;
        } else {
            $centerLength = $requiredRails['center'];
            $centerCount = $optimalCombination['center-'.$centerLength] * $usedMax;
            if (0 !== $centerCount) {
                $instructions[1] = "Cut ($centerCount) {$centerLength}mm rail(s)";
            }
            $intermediateLength = $requiredRails['intermediate'];
            $intermediateCount = $optimalCombination['intermediate-'.$intermediateLength] * $usedMax;
            if (0 !== $intermediateCount) {
                $instructions[1] .= " &amp; ($intermediateCount) {$intermediateLength}mm rail(s)";
            }
            $endLength = $requiredRails['end'];
            $endCount = $optimalCombination['end-'.$endLength] * $usedMax;
            if (0 !== $endCount) {
                $instructions[1] .= " &amp; ($endCount) {$endLength}mm rail(s)";
            }
            $instructions[1] .= " from ($usedMax) {$stockRails[$stockRail]}mm stock rails.";
            $stockRailQuantity[$stockRails[$stockRail]] += $usedMax;
        }
        
        $i = 2;
        foreach ($requiredRails as $position => $length) {
            if (0 == $fullSections[$position]) {
                ;
            } else {
                $cut = $fullSections[$position] * $fromStock[$position];
                $instructions[$i] .= "Cut ($cut) {$length}mm rail(s) from ({$fullSections[$position]}) {$mostEfficientStockRails['choose'][$position]}mm stock rails.";
            }
            $i++;
            $stockRailQuantity[$mostEfficientStockRails['choose'][$position]] += $fullSections[$position];
        }
        
        return compact('railsShipping', 'totalShippingLength', 'wasteLength', 'wastePercentage', 'instructions', 'stockRailQuantity');
    }
    

/***************************************************************************/
//Redo rail calculation
//$landscape = false;
$moduleRowtemp ;
$moduleRowtemp = $moduleRow * 2;  
/******************************** num of stock ****************************/
// $moduleRowtemp;
 $stock1 = $centerrowcount * $moduleRowtemp;
 $stock2 = $IntermediateRailRow * $moduleRowtemp;
 $stock3 = $EndRailRow * $moduleRowtemp;

if($trailtest == "false" && $RailColumnTF ){
 $tempc = $onespanrail[0]; 
 $tempInt = $onespanrail[1];  
}elseif($sysLength <= $stockLen){
 $tempc=  $sysLength; $tempInt= 0 ;}else{ 
 $tempc = $center;
 $tempInt = $IntermediateRailCut; 
}

//get minimum stock
$numStockCenter    = floor($stockLen / $tempc);
$numStockCenterMin = min($numStockCenter,$stock1);
$numStockInterm    = floor($stockLen / $tempInt);
$numStockIntermMin = min($numStockInterm,$stock2);
$numStockEnd       = floor($stockLen  / $EndRailCut);  
$numStockEndMin    = min($numStockEnd,$stock3);

//percentage from stock
$perStockCenter  = 1/$numStockCenterMin;
$perStockInterm  = 1/$numStockIntermMin;
$perStockEnd     = 1/$numStockEndMin;

//Simple stock value
$stock1simple = ceil($stock1   * $perStockCenter);
$stock2simple  = ceil($stock2   * $perStockInterm);
$stock3simple  = $stock3   * $perStockEnd;

//Rail count simple version 
$railCountb4round = $stock1simple + $stock2simple + $stock3simple;
$railCount = ceil($railCountb4round);
if($railCount == 0 || $railCount == 1 || ($railCount >= 4 && $railCount <= 5 )){
$railCount = 4;	
}

 $cutstock = $stock1simple * $numStockCenterMin;

 $cutstock2 = $stock2simple * $numStockIntermMin;

 $cutstock3 = $stock3simple * $numStockEndMin;
 
 

$simpleCutDesc= "";
 if($cutstock != 0 ){


$simpleCutDesc .= "Cut " . "(".$cutstock.")"  . round($center,-1) . "mm rails(s) from " .  "(".$stock1simple.")" . " 6200mm stock rails.";  
//$simpleCutDesc .= "<br>Cut " . "(".$cutstock2.")" .  $IntermediateRailCut . "mm rail(s) from " . "(".$stock2simple.")" . " 6200 stock rails"; 
//$simpleCutDesc .= "<br>Cut " . "(".$cutstock3.")" .  $EndRailCut . "mm rail(s) from " . "(".$stock3simple.")" . " 6200 stock rails"; 
}

if($cutstock2 != 0 ){
//$simpleCutDesc .= "Cut " . "(".$cutstock.")"  . $center . "mm rails(s) from " .  "(".$stock1simple.")" . " 6200mm stock rails.";  
$simpleCutDesc .= "<br>Cut " . "(".$cutstock2.")" .  round($IntermediateRailCut,-1) . "mm rail(s) from " . "(".$stock2simple.")" . " 6200 stock rails"; 
//$simpleCutDesc .= "<br>Cut " . "(".$cutstock3.")" .  $EndRailCut . "mm rail(s) from " . "(".$stock3simple.")" . " 6200 stock rails"; 
}

if($cutstock3 != 0 ){
//$simpleCutDesc .= "Cut " . "(".$cutstock.")"  . $center . "mm rails(s) from " .  "(".$stock1simple.")" . " 6200mm stock rails.";  
//$simpleCutDesc .= "<br>Cut " . "(".$cutstock2.")" .  $IntermediateRailCut . "mm rail(s) from " . "(".$stock2simple.")" . " 6200 stock rails"; 
$simpleCutDesc .= "<br>Cut " . "(".$cutstock3.")" .  $EndRailCut . "mm rail(s) from " . "(".$stock3simple.")" . " 6200 stock rails"; 
}


// complex rail cut calc
function cutting_rail_calc($center , $IntermediateRailCut, $EndRailCut , $stockLen){
	
	$beststock = array();
	$stocktstarr = array(
	"stocktst1" => array(1,1,0, $center + $IntermediateRailCut),
	"stocktst2" => array(1,0,1, $center + $EndRailCut),
	"stocktst3" => array(0,1,1, $IntermediateRailCut + $EndRailCut),
	"stocktst4" => array(1,1,1, $center + $IntermediateRailCut + $EndRailCut),
	"stocktst5" => array(2,1,0, (2 * $center) + $IntermediateRailCut ),
	"stocktst6" => array(2,0,1, (2 * $center) + $EndRailCut ),
	"stocktst7" => array(0,2,1, (2 * $IntermediateRailCut) + $EndRailCut ),
	"stocktst8" => array(0,1,2, $IntermediateRailCut + (2 * $EndRailCut))
	);

	//var_dump($stocktstarr);
	
	foreach( $stocktstarr as $s => $stock){
		if($stock[3] < $stockLen){
			$beststock[$s] = $stock;
			
		}		
	}
	
	
	 $optimalarr = array();
	foreach ($beststock as $key => $value) {
	array_push($optimalarr , $value[3]);
	}	
	

	$maxoptimal =  max($optimalarr);
	
	
	$tmp = array();		
	foreach ($beststock as $key => $value) {
		$val =  ceil($value[3]);
		if($val === ceil($maxoptimal)){			
			$tmp[$key] = $value;
			}
	}
	$first = __::first($tmp);

	
		
    return $first;
} 


//Calculate cut stock and cut instruction.
$stocktstarr = cutting_rail_calc($center , $IntermediateRailCut, $EndRailCut , $stockLen);


foreach($stocktstarr as $numR => $stock){
	if($stock < 0 ){
		$numReq1 = 0;		
		$numReq2 = 0;
		$numReq3 = 0;
	}else{
		$numReq1 = $stock1;
		$numReq2 = $stock2;
		$numReq3 = $stock3;	
		$size1 	 = $center;
		$size2   = $IntermediateRailCut;
		$size3   = $EndRailCut;
	}
}

//get the used sets 
$numReqArr = array($numReq1, $numReq2, $numReq3);
$usedSize;
if($stocktstarr[0] >0 || $stocktstarr[1] > 0 || $stocktstarr[2] >0){
	$usedSize = min($numReqArr);
}

function Optimalreturn($stocktstarr){
if($stocktstarr > 0 ){return 1;}else{ return 0;}
}

 $Railleft1 =  $numReq1 - $usedSize  * Optimalreturn($stocktstarr[0]);
 $Railleft2 =  $numReq2 - $usedSize  * Optimalreturn($stocktstarr[1]);
 $Railleft3 =  $numReq3 - $usedSize  * Optimalreturn($stocktstarr[2]);


$RailCutStockLeft1 = ceil($Railleft1 / $numStockCenter) ;
$RailCutStockLeft2 = ceil($Railleft2 / $numStockInterm) ;
$RailCutStockLeft3 = ceil($Railleft3 / $numStockEnd) ;
 
$CuttingStockRails  = $usedSize + $RailCutStockLeft1 + $RailCutStockLeft2 + $RailCutStockLeft3;

 $optimalSet1 = $stocktstarr[0] * $usedSize;
 $optimalSet2 = $stocktstarr[1] * $usedSize;
 $optimalSet3 = $stocktstarr[2] * $usedSize;

if($optimalSet1 == 0){
	$CutDescp = "";
}else{
	$CutDescp .= "Cut ". "(".$RailCutStockLeft2.") " . round($size2,-1). "mm rail(s) from " .  "(".$RailCutStockLeft2.") "  . " 6200mm stock rails";
	$CutDescp .= "<br>Cut " . "(".$Railleft3.") "    . round($size3,-1) . "mm rail(s) from "   . "(".$RailCutStockLeft3.")" . " 6200mm stock rails";
}

if($optimalSet1 > 0 ){ 
$CutDescp .= "<br>Cut ". "(".$optimalSet1.") " . round($size1,-1). "mm rail(s) from & ";
}
if($optimalSet2 > 0 ){
if($optimalSet3 == 0) { $add = "";}else{ $add = "&"; }
 $CutDescp .= "Cut ". "(".$optimalSet2.") " . round($size2,-1). "mm rail(s) "  . $add;
}

if($optimalSet3 > 0 ){
 $CutDescp .= " (".$optimalSet3.") " . round($size3,-1). " mm rail(s)" .  " from " . "(". $optimalSet3.")"  ." 6200mm stock rails" ;
}


if($CuttingStockRails == 0 || $CuttingStockRails ==Null){
$CuttingStockRail = $railCount;
}else{
$CuttingStockRail = $CuttingStockRails;
}
/***************************** END OF CUT STOCK CALC ****************************/


//$spliceCountTotal = (($totalRailRow)-1) * 4 ;
/*********************************************************************/

// One span rail call	
//$onespanrail = onespanrail( $cantileverMM , $spanMM , $sysLength);	
// get the One span rail array 	
function onespanrail( $cantileverMM , $spanMM , $sysLength){
$w = floatval(1000); // lb/ft
$a = floatval($cantileverMM); // cantilever mm 
$b = floatval($spanMM);   //span mm
$c = floatval($cantileverMM); // cantilever mm
$sum = floatval( $a + $b + $c);  
$feet = 304.8;

// convert mm to feet
$aft = floatval($a / $feet);
$bft = floatval($b / $feet);
$cft = floatval($a / $feet);

// convert sum mm to feet 
$sumft = floatval($sum / $feet);

// R1 value
$R1 = floatval(($w * $sumft *($sumft - 2 * $cft )) / ( 2 * $bft));
$row = 50;

$xcol = array();
$Mxcol= array();

// get the X values
for($i = 0 ; $i <= $row ; $i++){
$xcol[$i] =  round(($bft / ($row)) * $i,2);
}

$mxcolabs= array();

//get the Mx values
for($k = 0 ; $k <= count($xcol) ; $k++){
$Mxcol[$k] = round($R1  * $xcol[$k] -( $w *  pow(( $aft + $xcol[$k] ),2) )/2 ,2); 
}

//Absolute value or mx column array
foreach ($Mxcol as $key => $val){
$mxcolabs[$key] = abs($val);
}

$mxval = min($mxcolabs);

//New temp 2d array
$tmp = array();
foreach($xcol as $v => $va){
	$tmp[$v]['x'] = $va;
}

foreach($Mxcol as $as => $aa){
	$tmp[$as]['mx'] = $aa;
}

// add key value to 2d array 
$output = array_values($tmp);


//get the Mfind 
$mfind = array();
foreach($tmp as $tmpval){
if(abs($tmpval['mx']) ==  $mxval ){
  $mfind[] = $tmpval['x'];
	//break;
	}	
}

//echo "<pre>" .print_r($mfind,1)."</pre>";
// convert mfind to mm
$mfindmm = floatval($mfind[0] * $feet); 
$splice = $mfindmm + $a ;
$rail1 = $splice;
$rail2 =  $sysLength - $splice;
	
$onespan = array();

$onespan[0] = $rail1;
$onespan[1] = $rail2;

return $onespan;
} // end one span rail	


/*********************************************************************************/
	
//sort potential array get second highest
function idealEndRailCheck8($EndMaxs){
if($EndMaxs[count($EndMaxs)-1] == 0  || $EndMaxs[count($EndMaxs)-4] ==  NULL ){return 0;}else{
return  $EndMaxs[count($EndMaxs)-1];	}		
}

idealEndRailCheck5($EndMaxs);
//sort potential array get second highest
function idealEndRailCheck5($EndMaxs){
return  $EndMaxs[count($EndMaxs)-2];			
}

idealEndRailCheckfirsthigh($EndMaxs);
//sort potential array get first highest
function idealEndRailCheckfirsthigh($EndMaxs){
return  $EndMaxs[count($EndMaxs)-1];			
}

idealEndRailCheck6($EndMaxs);
//sort potential array get third from highest
function idealEndRailCheck6($EndMaxs){
if ($EndMaxs[count($EndMaxs)-3] == 0 || $EndMaxs[count($EndMaxs)-3] == NULL) {return 0;} else { return $EndMaxs[count($EndMaxs)-3]; };			
}

idealEndRailChecktrail($EndMaxs);
//sort potential array get second highest
function idealEndRailChecktrail($EndMaxs){
  if($EndMaxs[count($EndMaxs)-4] == 0 || $EndMaxs[count($EndMaxs)-4] ==  NULL )
  {return 0; }else {return $EndMaxs[count($EndMaxs)-4];};			
}

function idealMidRailCheck2($maxpotcenter, $stockLen, $sysLength,$crow1){
 if($crow1 > $maxpotcenter){return $maxpotcenter ;}else{ return 0;}
}

//echo $InteriorRailCheck4;

function idealMidRailCheck4($InteriorRailCheck4,  $tmpRailArr){
	//echo "<pre>",print_r($tmpRailArr),"</pre>";
	foreach($tmpRailArr as $tarr){
		
		if(round($InteriorRailCheck4,2) === round($tarr,2))
		{
			return $tarr;
		}else{
			return 0;
		}
	}

}

function idealMidRailcheck5($InteriorRailCheck5,  $tmpRailArr){
	
	foreach($tmpRailArr as $tarr){
		
		if(round($InteriorRailCheck5,2) === round($tarr,2))
		{
			return $tarr;
		}else{
			return 0;
		}
	}
}

function idealMidRailcheck6($InteriorRailCheck6,  $tmpRailArr){
		//echo "<pre>",print_r($tmpRailArr),"</pre>";
		//echo $InteriorRailCheck6;
	foreach($tmpRailArr as $tarr){
	
		if(ceil($InteriorRailCheck6) === ceil($tarr))
		{
			return $tarr;
		}else{
			return 0;
		}
	}
}
function InteriorRailLengGreaterIdealMidRail($idealMidRailCheck4,$InteriorRailCheck4, $stockLen , $idealEndRail){
	if($idealMidRailCheck4 == 0){return "false";}elseif($InteriorRailCheck4 > $stockLen || $idealEndRail == 0 ){ return "false"; }else{return "true";}
}

function InteriorRailLengGreaterIdealMidRail5($idealMidRailCheck5,$InteriorRailCheck5, $stockLen , $idealEndRailCheck5){
	if($idealMidRailCheck5 == 0){return "false";}elseif($InteriorRailCheck5 > $stockLen || $idealEndRailCheck5 == 0 ){ return "false"; }else{return "true";} 
}
 
function idealEndRail($EndRailMax, $stockLen, $sysLength){
	if($EndRailMax <= $stockLen){return $EndRailMax;}else{return 0;}
} 
function idealMidRail($maxpotcenter, $stockLen, $sysLength){
if($sysLength <= $stockLen){
	 $idealMidRail = $sysLength;	
}else{
	 $idealMidRail = $maxpotcenter;	
}
	return  $idealMidRail;
}

//get cantilever + 75%
function cantileverPlus75($cantileverMM , $spanMM){
	return   $cantplus75 = $cantileverMM + (( 1 - .25) * $spanMM); 
}

// check end rail >= cantilever + 75%
function checkCantilever($idealMidRail, $sysLength, $stockLen, $endRail, $cantileverPlus75 ){
	
if($idealMidRail == 0 ){
		return "false";
	}else {
		if($sysLength <= $stockLen){
			return "true";	
		}else if($endRail < $cantileverPlus75 ){
				return "false";	
			}else{ 
			return "true";
			}
	}
}

// get Interior rail length
function getInteriorRailLength($remainRail,$EndRackRemainCenter, $IntermediateMaxs){
				
		return 	($EndRackRemainCenter -  max($IntermediateMaxs) * floor($remainRail)) * 2;
}

// get Interior rail length
function getInteriorRailLength5($remainRailCheck5,$EndRackRemainCheck5, $IntermediateMaxs){
				$InteriorRailLength5 = ($EndRackRemainCheck5 -  max($IntermediateMaxs) * floor($remainRailCheck5)) * 2;
		return 	$InteriorRailLength5;
}


//get Interior Rail Length check 6,7,8
function getInteriorRailLength678( $idealremainRailCheck6, $EndRackRemainCheck6, $remainRailCheck){
				
		return 	(($EndRackRemainCheck6) - $idealremainRailCheck6 * floor($remainRailCheck)) * 2;
}

function getInteriorRailLength6( $idealremainRailCheck6, $EndRackRemainCheck6, $remainRailCheck6){
	    //echo $EndRackRemainCheck6;
	    //echo $remainRailCheck6;
		$InteriorRailLength6 = 	 (($EndRackRemainCheck6) - $idealremainRailCheck6 * floor($remainRailCheck6)) * 2 ;
		//$InteriorRailLength6= 	$idealremainRailCheck6 - $EndRackRemainCheck6  * round($remainRailCheck,PHP_ROUND_HALF_DOWN)* 2;
		return 	floatval($InteriorRailLength6);
}

function getInteriorRailLength8( $idealremainRailCheck8, $EndRackRemainCheck8, $remainRailCheck){
				
		return ($idealremainRailCheck8 - $EndRackRemainCheck8  * $remainRailCheck) * 2;
}

//get end rack remain from center
function getEndRackRemainCenter($idealEndRail , $sysLength){
	return ($sysLength - $idealEndRail * 2 ) / 2;
}

//get end rack remain from center not floor
function getEndRackRemainCenterC6($idealEndRail , $sysLength){
	return ($sysLength - $idealEndRail * 2 ) / 2;
}
//get rack remain from center 
function getRackRemainCenter($sysLength, $maxpotcenter){
	return	 $rackRemainFromCenter = ($sysLength - $maxpotcenter)/2;
}

//get remaing rails
//$remainRailCheck2 = getRemainRails( 9320.3,$IntermediateMaxes);
function getRemainRails( $rackRemain,$IntermediateMaxs){
	return $rackRemain / max($IntermediateMaxs);}

//get ideal rail check 6,7,8	
function getRemainRails678($EndRackRemainCheck6 , $idealremainRailCheck6){
	
	return ($EndRackRemainCheck6 / $idealremainRailCheck6);
}

function getRemainRails8($EndRackRemainCheck8 , $idealremainRailCheck8){
	$remainRail8 = $EndRackRemainCheck8 / $idealremainRailCheck8;
	return $remainRail8;
}

function getRemainRailsCheck6( $stockLen,$minIntermediate){
	if($minIntermediate <= $stockLen){return $minIntermediate;}else{return 0;};}
	
//get end rails length
function getEndRailLength( $remainingRails, $IntermediateMaxs){
	return  max($IntermediateMaxs) * ( $remainingRails - floor($remainingRails));
}


//check support if odd
function isodd($support){
  if($support&1) { return true; }else{ return false;} 	
}

//check support if even
function iseven($support){
  if($support %  2 == 0){return true;}else {return false;}
}

//Find triangle product SAP# for tilt
function triangleTilt($tilt){
if ($tilt == 15){
	return "146002-215";
}elseif ($tilt == 20){
	return "146002-220";
}elseif ($tilt == 25){
	return "146002-225";
}
elseif ($tilt == 30){
	return "146002-230";
}
else{
	return "146002-035";
}
}
triangleTilt($tilt);

$triangleItem = triangleTilt($tilt);

$endClamp = $db->getAllClampsByThicknessNone($module_thickness, 'end');
$endClamp = $endClamp[0];

$middleClamp = $db->getAllClampsByThickness($module_thickness, 'mid','portrait');
$middleClamp = $middleClamp[0];

//calculate endclamp and middle clamp quantity
$endclampqty = 8;  
//$middleClampqty  = ((($moduleCount * 2 ) - 2) * 2);
$middleClampqty = (($moduleCount -1) *4);

//get safety hook if endclamp is 3
if($endClamp['id'] == '40'  ){
$laminatehook =  $db->getLaminateSafetyHook('139008-003');
$laminatehook =  $laminatehook[0];
};

//get safety hook if endclamp is 1
if($endClamp['id'] == '42' ){
$laminatehook =  $db->getLaminateSafetyHook('139008-004');
$laminatehook = $laminatehook[0];
};

$laminatehookqty = ($moduleCount - 1) * 2;



//multiply rack to parts list quantity
if(isset($rack_quantity) &&  $rack_quantity != 0 || $rack_quantity != null){
   $bestresults["stockRailQuantity"][4200]  = $bestresults["stockRailQuantity"][4200] * $rack_quantity;
   $bestresults["stockRailQuantity"][6200]  = $bestresults["stockRailQuantity"][6200] * $rack_quantity;
   $bestresults["railsShipping"] = $bestresults["railsShipping"] * $rack_quantity;
   $spliceCountTotal = $spliceCountTotal * $rack_quantity;
   $supportTriCount =  $supportTriCount * $rack_quantity;
   $standoffCount = $standoffCount * $rack_quantity;
   $solTubCount = $solTubCount * $rack_quantity;
   $solTubHardwareCount = $solTubHardwareCount * $rack_quantity;
   $endclampqty = $endclampqty * $rack_quantity;
   $middleClampqty = $middleClampqty * $rack_quantity;
   $laminatehookqty = $laminatehookqty * $rack_quantity;
}else{
  	
}
?>

<script type="text/javascript">
// Testing / debug 
var span          = '<?php   echo $span; ?>';
var support       = '<?php   echo $support; ?>';
var railcount     = '<?php   echo $railCountb4round; ?>';
var systemlen     = '<?php   echo $sysLength ?>';
var stocklen2x    = '<?php 	 echo $stockLen2x ?>';
var idealRemCent  = '<?php 	 echo $idealRackRemainCenter10 ?>';
var stocklen 	  = '<?php 	 echo $stockLen ?>';
var idealEndRailCheck10 = '<?php echo $idealEndRailCheck10 ?>';

//var  IntermediateRailLengthCheck10 = '<?php //echo $IntermediateRailLengthCheck10 ?>';
//var IntermRailCut = '<?php //echo $IntermRailCut; ?>';


</script>