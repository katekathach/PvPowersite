<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
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
   
   
   
  /*   function getTilt($system ,$cell , $code ){
	  
	  $sql = "SELECT DISTINCT `Tilt` FROM `".$system."_".$cell."cell_".$code."`" .
        " where `Tilt` = '$tilt' ";
      $tilt = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $wind[] = array("wind" => $row["Wind"]);
         }
      }
		//echo $sql;
      return $tilt;

  }*/
  
 function getWind($system , $tilt , $cell , $code ){
	  
	  $sql = "SELECT DISTINCT `wind` FROM `".$system."_".$cell."cell_".$code."`" .
        " where `tilt` = '$tilt' ";
      $wind = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $wind[] = array("wind" => $row["wind"]);
         }
      }
		//echo $sql;
      return $wind;

  }
  
  function getSnow($system , $tilt , $cell , $code ){
	  
	  $sql = "SELECT DISTINCT `ground_snow` FROM `".$system."_".$cell."cell_".$code."`" .
        " where `tilt` = '$tilt' ";
      $snow = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $snow[] 	= array("ground_snow" => $row["ground_snow"]);
         }
      }
	//echo $sql;
      return $snow;

  }
  
  
  /********************* pv max 60 cell **************************/
  
  	
function get_pvmax_60cell_05($tilt, $wind, $snow){
		$sql = "SELECT `max_span`, `ballast_width`, `rebar` , `front_conne_tension` , `front_conne_compression` , `front_conne_shear` ,
		`rear_conne_tension` , `rear_conne_compression` , `rear_conne_shear`  FROM `pvmax_60cell_05`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $pvmax_60cell_05 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $pvmax_60cell_05[] = array(
                              "max_span"      => $row["max_span"],
                              "ballast_width" => $row["ballast_width"],
							  "front_conne_tension" => $row["front_conne_tension"],
							  "front_conne_compression" => $row["front_conne_compression"],
							  "front_conne_shear" => $row["front_conne_shear"],
							  "rear_conne_tension" => $row["rear_conne_tension"],
							  "rear_conne_compression" => $row["rear_conne_compression"],
							  "rear_conne_shear" => $row["rear_conne_shear"],							  
                              "rebar"    => $row["rebar"]);
         }
      }
	  
      return $pvmax_60cell_05;
	
	}
	
	function get_pvmax_60cell_05_seis($tilt, $wind, $snow){
		$sql = "SELECT `max_span`, `ballast_width`, `rebar` , `front_conne_tension` , `front_conne_compression` , `front_conne_shear` ,
		`rear_conne_tension` , `rear_conne_compression` , `rear_conne_shear`   FROM `pvmax_60cell_05_seis`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $pvmax_60cell_05_seis = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $pvmax_60cell_05_seis[] = array(
                              "max_span"      => $row["max_span"],
                              "ballast_width" => $row["ballast_width"],
							  "front_conne_tension" => $row["front_conne_tension"],
							  "front_conne_compression" => $row["front_conne_compression"],
							  "front_conne_shear" => $row["front_conne_shear"],
							  "rear_conne_tension" => $row["rear_conne_tension"],
							  "rear_conne_compression" => $row["rear_conne_compression"],
							  "rear_conne_shear" => $row["rear_conne_shear"],							  
                              "rebar"    => $row["rebar"]);
         }
      }
      return $pvmax_60cell_05_seis;
	
	}
	
	
  
   function get_pvmax_60cell_10($tilt, $wind,$snow){
		$sql = "SELECT `max_span`, `ballast_width`, `rebar` , `front_conne_tension` , `front_conne_compression` , `front_conne_shear` ,
		`rear_conne_tension` , `rear_conne_compression` , `rear_conne_shear`   FROM `pvmax_60cell_10`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $pvmax_60cell_10 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $pvmax_60cell_10[] = array(
                              "max_span"      => $row["max_span"],
                              "ballast_width" 	=> $row["ballast_width"],
							  "front_conne_tension" => $row["front_conne_tension"],
							  "front_conne_compression" => $row["front_conne_compression"],
							  "front_conne_shear" => $row["front_conne_shear"],
							  "rear_conne_tension" => $row["rear_conne_tension"],
							  "rear_conne_compression" => $row["rear_conne_compression"],
							  "rear_conne_shear" => $row["rear_conne_shear"],							  
                              "rebar"    => $row["rebar"]);
         }
      }
	 
    return $pvmax_60cell_10;

	}
	
	   function get_pvmax_60cell_10_seis($tilt, $wind,$snow){
		$sql = "SELECT `max_span`, `ballast_width`, `rebar` , `front_conne_tension` , `front_conne_compression` , `front_conne_shear` ,
		`rear_conne_tension` , `rear_conne_compression` , `rear_conne_shear`   FROM `pvmax_60cell_10_seis`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $pvmax_60cell_10_seis = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $pvmax_60cell_10_seis[] = array(
                              "max_span"      => $row["max_span"],
                              "ballast_width" => $row["ballast_width"],
							  "front_conne_tension" => $row["front_conne_tension"],
							  "front_conne_compression" => $row["front_conne_compression"],
							  "front_conne_shear" => $row["front_conne_shear"],
							  "rear_conne_tension" => $row["rear_conne_tension"],
							  "rear_conne_compression" => $row["rear_conne_compression"],
							  "rear_conne_shear" => $row["rear_conne_shear"],							  
                              "rebar"    => $row["rebar"]);
         }
      }
	 

      return $pvmax_60cell_10_seis;

	}

 	/*******************************************************************/
	


/*********************************pv max 72 ****************************************/
function get_pvmax_72cell_05($tilt, $wind, $snow){
	$sql = "SELECT `max_span`, `ballast_width`, `rebar` , `front_conne_tension` , `front_conne_compression` , `front_conne_shear` ,
		`rear_conne_tension` , `rear_conne_compression` , `rear_conne_shear`  FROM `pvmax_72cell_05`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $pvmax_72cell_05 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $pvmax_72cell_05[] = array(
                              "max_span"    => $row["max_span"],
                              "ballast_width" => $row["ballast_width"],
							  "front_conne_tension" => $row["front_conne_tension"],
							  "front_conne_compression" => $row["front_conne_compression"],
							  "front_conne_shear" => $row["front_conne_shear"],
							  "rear_conne_tension" => $row["rear_conne_tension"],
							  "rear_conne_compression" => $row["rear_conne_compression"],
							  "rear_conne_shear" => $row["rear_conne_shear"],							  
                              "rebar"    => $row["rebar"]);
         }
      }
      return $pvmax_72cell_05;
 
}

function get_pvmax_72cell_05_seis($tilt, $wind, $snow){
	$sql = "SELECT `max_span`, `ballast_width`, `rebar` , `front_conne_tension` , `front_conne_compression` , `front_conne_shear` ,
		`rear_conne_tension` , `rear_conne_compression` , `rear_conne_shear`  FROM `pvmax_72cell_05_seis`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $pvmax_72cell_05_seis = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $pvmax_72cell_05_seis[] = array(
                              "max_span"    => $row["max_span"],
                              "ballast_width" => $row["ballast_width"],
							  "front_conne_tension" => $row["front_conne_tension"],
							  "front_conne_compression" => $row["front_conne_compression"],
							  "front_conne_shear" => $row["front_conne_shear"],
							  "rear_conne_tension" => $row["rear_conne_tension"],
							  "rear_conne_compression" => $row["rear_conne_compression"],
							  "rear_conne_shear" => $row["rear_conne_shear"],							  
                              "rebar"    => $row["rebar"]);
         }
      }
      return $pvmax_72cell_05_seis;
 
}

function get_pvmax_72cell_10($tilt, $wind, $snow){
	$sql = "SELECT `max_span`, `ballast_width`, `rebar` , `front_conne_tension` , `front_conne_compression` , `front_conne_shear` ,
		`rear_conne_tension` , `rear_conne_compression` , `rear_conne_shear`   FROM `pvmax_72cell_10`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $pvmax_72cell_10 = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $pvmax_72cell_10[] = array(
                              "max_span"    => $row["max_span"],
                              "ballast_width" => $row["ballast_width"],
							  "front_conne_tension" => $row["front_conne_tension"],
							  "front_conne_compression" => $row["front_conne_compression"],
							  "front_conne_shear" => $row["front_conne_shear"],
							  "rear_conne_tension" => $row["rear_conne_tension"],
							  "rear_conne_compression" => $row["rear_conne_compression"],
							  "rear_conne_shear" => $row["rear_conne_shear"],							  
                              "rebar"    => $row["rebar"]);
         }
      }
      return $pvmax_72cell_10;
	
}

function get_pvmax_72cell_10_seis($tilt, $wind, $snow){
	$sql = "SELECT `max_span`, `ballast_width`, `rebar` , `front_conne_tension` , `front_conne_compression` , `front_conne_shear` ,
		`rear_conne_tension` , `rear_conne_compression` , `rear_conne_shear`   FROM `pvmax_72cell_10_seis`" .
        " where `tilt` = '$tilt' and `wind` = '$wind' and `ground_snow` = '$snow'";
      $pvmax_72cell_10_seis = array();
      if($result = mysql_query($sql))
      {
         while ($row = mysql_fetch_assoc($result))
         {
             $pvmax_72cell_10_seis[] = array(
                              "max_span"    => $row["max_span"],
                              "ballast_width" => $row["ballast_width"],
							  "front_conne_tension" => $row["front_conne_tension"],
							  "front_conne_compression" => $row["front_conne_compression"],
							  "front_conne_shear" => $row["front_conne_shear"],
							  "rear_conne_tension" => $row["rear_conne_tension"],
							  "rear_conne_compression" => $row["rear_conne_compression"],
							  "rear_conne_shear" => $row["rear_conne_shear"],							  
                              "rebar"    => $row["rebar"]);
         }
      }
      return $pvmax_72cell_10_seis;
	
}
	
/********************************************************************************/	
	
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
      
      /* free result set */
      //$result->free(); 
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
      
	  //var_dump($clamps);
      return $clamps;
      
      /*free result set*/
      //$result->free(); 
	  
 }
	
function getLaminateSafetyHook($item){
	//echo $item;
	//if(is_string($item)){echo "yes";}else{echo "NO";}
$sql = "SELECT `id`,`item_number`,`description`,`unit_price` FROM `calculator_hardwares` WHERE `item_number` = '$item'";
	//echo $sql;

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