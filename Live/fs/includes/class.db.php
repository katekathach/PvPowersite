<?php
//error_reporting(-1);
// Get config file.
require_once('protected/flat-roof-properties.php');
   
   
class DB
{
  var $db;
   
   function __construct()
   {
	  try{
      if(!$this->db = mysql_connect(DB_HOST, DB_USER, DB_PASS))
              die('Error 1001: Unable to connect to the database.');
      mysql_select_db(DB_NAME, $this->db);
	  
	   }catch(Exception $e ){
		  echo $e->getMessage();
	  }
   }
  
  function getWind($system , $tilt , $cell , $code , $includeseis){
	  
	  $sql = "SELECT DISTINCT `wind` FROM `".$system."_".$cell."_".$code."_".$includeseis."`" .
        " where `tilt` = '$tilt' ";
      $wind = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $wind[] = array("wind" => $row["wind"]);
         }
      }

      return $wind;

  }
  
    function getSnow($system , $tilt , $cell , $code , $includeseis){
	  
	  $sql = "SELECT DISTINCT `ground_snow` FROM `".$system."_".$cell."_".$code."_".$includeseis."`" .
        " where `tilt` = '$tilt' ";
      $wind = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $wind[] 	= array("ground_snow" => $row["ground_snow"]);
         }
      }

      return $wind;

  }
	
   function get_FS_60_07_05_s($tilt, $wind,$snow){
		$sql = "SELECT `max_span`, `tension_force`, `shear_force`, `drilled_shaft_depth`  FROM `FS_60_7_05_s`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $FS60_07_05 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
            
			 $FS60_07_05[] 	= array(
                              "max_span"      			=> $row["max_span"],
                              "tension_force" 	  		=> $row["tension_force"],
							  "shear_force"				=> $row["shear_force"],
                              "drilled_shaft_depth"    	=> $row["drilled_shaft_depth"]
							  );
         }
      }

      return $FS60_07_05;

	}
	
	   function get_FS_60_07_05_ns($tilt, $wind,$snow){
		$sql = "SELECT `max_span`, `tension_force`, `shear_force`, `drilled_shaft_depth`  FROM `FS_60_7_05_ns`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $FS60_07_05 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
            
			 $FS60_07_05[] 	= array(
                              "max_span"      			=> $row["max_span"],
                              "tension_force" 	  		=> $row["tension_force"],
							  "shear_force"				=> $row["shear_force"],
                              "drilled_shaft_depth"    	=> $row["drilled_shaft_depth"]
							  );
         }
      }

      return $FS60_07_05;

	}
	
	 
function get_FS_60_7_10_s($tilt, $wind, $snow){
		$sql = "SELECT `max_span`, `tension_force`, `shear_force`,`drilled_shaft_depth`  FROM `FS_60_7_10_s`" .
        "where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $FS_60_7_10 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $FS_60_7_10[] = array(
                            	"max_span"               => $row["max_span"],
                                "tension_force" 	     => $row["tension_force"],
								"shear_force"			 => $row["shear_force"],
                                "drilled_shaft_depth"    => $row["drilled_shaft_depth"]
								);
         }
      }
	 // echo print_r($FS_60_7_10);
      return $FS_60_7_10;

	}
	
	function get_FS_60_7_10_ns($tilt, $wind, $snow){
		$sql = "SELECT `max_span`, `tension_force`, `shear_force`,`drilled_shaft_depth`  FROM `FS_60_7_10_ns`" .
        "where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow' Limit 1";
      $FS_60_7_10 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $FS_60_7_10[] = array(
                            	"max_span"               => $row["max_span"],
                                "tension_force" 	     => $row["tension_force"],
								"shear_force"			 => $row["shear_force"],
                                "drilled_shaft_depth"    => $row["drilled_shaft_depth"]
								);
         }
      }
	 // echo print_r($FS_60_7_10);
      return $FS_60_7_10;

	}

function get_FS_72_7_05_s($tilt, $wind, $snow){
	$sql = "SELECT `max_span`, `tension_force`, `shear_force`, `drilled_shaft_depth`  FROM `FS_72_7_05_s`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $FS_72_7_05 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $FS_72_7_05[] = array(
			   "max_span"      			=> $row["max_span"],
               "tension_force" 			=> $row["tension_force"],
			   "shear_force"			=> $row["shear_force"],
               "drilled_shaft_depth"    => $row["drilled_shaft_depth"]
			   );
         }
      }
	  
	 // echo print_r($FS_72_7_05);
	  return $FS_72_7_05;
 
}

function get_FS_72_7_05_ns($tilt, $wind, $snow){
	$sql = "SELECT `max_span`, `tension_force`, `shear_force`, `drilled_shaft_depth`  FROM `FS_72_7_05_ns`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $FS_72_7_05 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $FS_72_7_05[] = array(
			   "max_span"      			=> $row["max_span"],
               "tension_force" 			=> $row["tension_force"],
			   "shear_force"			=> $row["shear_force"],
               "drilled_shaft_depth"    => $row["drilled_shaft_depth"]
			   );
         }
      }
	  
	 // echo print_r($FS_72_7_05);
	  return $FS_72_7_05;
 
}

function get_FS_72_7_10_s($tilt, $wind, $snow){
	$sql = "SELECT `max_span`, `tension_force` ,`shear_force`,`drilled_shaft_depth`   FROM `FS_72_7_10_s`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $FS_72_7_10 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             //$rm_penetrating_7_10[] = $row;
			 $FS_72_7_10[] = array(
                              "max_span"               => $row["max_span"],
                              "tension_force"          => $row["tension_force"],
							  "shear_force"            => $row["shear_force"],
                              "drilled_shaft_depth"    => $row["drilled_shaft_depth"]);
         }
      }
	  
     // echo print_r($FS_72_7_10);
      return $FS_72_7_10;
	
}

function get_FS_72_7_10_ns($tilt, $wind, $snow){
	$sql = "SELECT `max_span`, `tension_force` ,`shear_force`,`drilled_shaft_depth`  FROM `FS_72_7_10_ns`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $FS_72_7_10 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             //$rm_penetrating_7_10[] = $row;
			 $FS_72_7_10[] = array(
                              "max_span"               => $row["max_span"],
                              "tension_force"          => $row["tension_force"],
							  "shear_force"            => $row["shear_force"],
                              "drilled_shaft_depth"    => $row["drilled_shaft_depth"]);
         }
      }
	  
	// echo print_r($FS_72_7_10);
      return $FS_72_7_10;
	
}
	
function getAllClampsByThickness($thickness, $clampType, $moduleOrientation )
   	{      
      
	  $clampType = mysql_real_escape_string($clampType);
      //$moduleOrientation = $isLandscape ? 'landscape' : 'portrait';
	  $sql = "SELECT `id`, `thickness`, `item_number`, `description`, `unit_price`, `weight`, `type`," . 
        "`black_anodized`, `rapid`, `mod_orient` FROM `calculator_clamps`" .
        " where ABS($thickness - `thickness`) < 0.6" .
        " AND `type`='$clampType'" .  
        " AND `black_anodized`='no'" . 
        " AND (`mod_orient`='$moduleOrientation' OR `mod_orient`='both')";
      $clamps = array();
      if ($result = mysql_query($sql)) {
         while ($row = mysql_fetch_assoc($result))
         {
            $clamps[] = $row;
         }
      }
      
      return $clamps;
   }

function getAllClampsByThicknessNone($thickness, $clampType )
   	{      
      
	  $clampType = mysql_real_escape_string($clampType);
      //$moduleOrientation = $isLandscape ? 'landscape' : 'portrait';
	  $sql = "SELECT `id`, `thickness`, `item_number`, `description`, `type`," . 
        " `rapid` FROM `powersite_clamp`" .
        " where ABS($thickness - `thickness`) < 0.6" .
        " AND `type`='$clampType'" ;
      $clamps = array();
      if ($result = mysql_query($sql)) {
         while ($row = mysql_fetch_assoc($result))
         {
            $clamps[] = $row;
         }
      }
     
      return $clamps;
     
	}

	
function getLaminateSafetyHook($item){	
$sql = "SELECT `id`,`item_number`,`description`,`unit_price` FROM `calculator_hardwares` WHERE `item_number` = '$item'";
$hook = array();
if ($result = mysql_query($sql)) {
while ($row = mysql_fetch_assoc($result))
	{
    		$hook[] = $row;
	}
}
 return $hook;
}
}



?>