<?php
 ini_set('display_errors', '1');
 ini_set('error_reporting', E_ALL);
$path = "../";
require_once($path."includes/session.php");
//require_once($path.'includes/class.db.php');
//require_once($path.'includes/class.calculator.php');

if(isset($_POST["a"]))
   $_DATA = $_POST;
else
   $_DATA = $_GET;

if(isset($_DATA["a"]))
{
   //$db = new DB();
   
   switch($_DATA["a"])
   {
      case "mt":
         if(!isset($_DATA["v"]))
            throwError("No vendor specified.");
         else
         {
            $response = $db->getModuleTypes($_DATA["v"]);
            sendUTF8Response($response);
         }
         break;
      case "ct":
         if(!isset($_DATA["t"]))
            throwError("No roof type specified.");
         else if(!isset($_DATA["st"]))
            throwError("No roof subtype specified.");         
         else if(!isset($_DATA["c"]))
            throwError("No standoff height specified.");         
         else if(!isset($_DATA["rd"]))
            throwError("No rafter dimensions specified.");
         else
         {
            $roofType  = ((int) $_DATA["t"]);
            $subType   = ((int) $_DATA["st"]);
            $clearance = ((int) $_DATA["c"]);
            $rafters   = ((int) $_DATA["rd"]);
            
            $response = $db->getConnectionTypes($_DATA["t"],$_DATA["st"],$_DATA["c"],$_DATA["rd"]);
            sendUTF8Response($response);
         }
         break;
      case "rt":
         if(!isset($_DATA["t"]))
            throwError("No roof type specified.");
         else
         {
            $roofType  = ((int) $_DATA["t"]);
            
            $response = $db->getSubRoofTypes(true, $_DATA["t"]);
            sendUTF8Response($response);
         }
         break;
      case "dp":
         if(!isset($_DATA["p"]))
            throwError("No project id specified.");
         else
         {
            $projID = ((int) $_DATA["p"]);
            $db->deleteExistingProject($projID, $_SESSION["user_id"]);
            sendResponse(array("success"=>"1"));
         }
         break;
      case "cl":
         $userID = checkLogin();
         if($userID != -1)
            sendResponse(array("success"=>1));
         else
            sendResponse(array("success"=>0));
         break;
      case "mx":
         if(!isset($_DATA["l"]))
            throwError("No module length specified.");
         else if(!isset($_DATA["w"]))
            throwError("No module width specified.");         
         else if(!isset($_DATA["o"]))
            throwError("No orientation specified.");         
         else
         {
            $mLength     = $_DATA["l"];
            $mWidth      = $_DATA["w"];
            $orientation = $_DATA["o"];
            
            $maxes = Calculator::checkRoofFit($mLength, $mWidth, $orientation);
            sendResponse(array("rows"=>$maxes["maxRows"], "cols"=>$maxes["maxCols"]));
         }
         break;
      case "ukc":
         if(!isset($_DATA["pr"]) || empty($_DATA["pr"]))
            throwError("No province specified.");
         else
         {
            $cities = $db->getUKCities($_DATA["pr"]);
            $response = array();
            foreach($cities as $c)
            {
               $response[] = array(
                   "id"   => $c,
                   "name" => $c
               );
            }
            sendResponse(($response) );
         }
         break;
      case "ukz":
         if(!isset($_DATA["pr"]) || empty($_DATA["pr"]))
            throwError("No province specified.");
         else if(!isset($_DATA["c"]) || empty($_DATA["c"]))
            throwError("No province specified.");
         else
         {
            $zips = $db->getUKZips($_DATA["pr"], $_DATA["c"]);

            $response = array();
            foreach($zips as $z)
            {
               $response[] = array(
                   "id"   => $z,
                   "name" => $z
               );
            }
            sendResponse( $response );
         }
         break;
      default:
         throwError("Invalid action.");
         break;
   }
}
else
{
   throwError("No action specified.");
}

function throwError($msg)
{
   die( json_encode(array("Error"=>$msg)) );
}

function sendResponse($data)
{
   die(json_encode($data));
}

function sendUTF8Response($data)
{
   $str = "[";
   foreach($data as $d)
   {
      $str .= "{";
      foreach($d as $key=>$row)
      {
         $str .= '"'.$key.'":"'.htmlentities($row).'",';
      }
      $str = substr($str,0,-1)."},";
   }
   if(strlen($str) > 1)
      $str = substr($str,0,-1);
   $str .= "]";
   echo $str;
   die();
}
?>