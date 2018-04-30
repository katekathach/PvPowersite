<?php
error_reporting(E_ALL);
//ini_set('display_errors', 1);
$path = "../";
require_once($path."includes/session.php");
//require_once($path.'includes/class.db.php');

if(isset($_POST["a"]))
   $_DATA = $_POST;
else
   $_DATA = $_GET;
  
  if(isset($_DATA["a"]))
{
   
   switch($_DATA["a"])
   {
	   case "cl":
	   
	    $userID = checkLogin();
        if($userID != -1)
        sendResponse(array("success"=>1));
         else
        sendResponse(array("success"=>0));
        break;
   }
}else{
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