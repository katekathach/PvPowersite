<?php

session_start();

if(!isset($path))
   $path = "";
require_once($path."protected/flat-roof-properties.php");


checkLogin();

//require_once('includes/class.db.php');
//require_once('includes/constants.php');

/*
 * Function used to see if the user is logged in.
 * If we're in development, then we pull the data
 * from a fake cookie (plain text file with a single
 * integer value for the content).
 */
function checkLogin()
{
   global $path;

//echo $_COOKIE["mm5-S-basket-id"];
 //  if(ENVIRONMENT == 'production')
  // {
      // Pull user ID from Miva. 
      if(isset($_COOKIE["mm5-S-basket-id"]))
         $miva_sess_id = $_COOKIE['mm5-S-basket-id'];
		 
      else
         $miva_sess_id = "";
      $curl_opt = strpos($_SERVER['HTTP_HOST'], 'dev')!==false ? '-ku schletterdev:modules8kW' : '-k';
      $cmd = "curl $curl_opt 'https://".$_SERVER['HTTP_HOST']."/mm5/merchant.mvc?Session_ID=$miva_sess_id&Store_Code=S&Screen=C_ID'";
      $session_arr = preg_split('/\s/', exec($cmd));
      if (isset($session_arr[0]) && !empty($session_arr[0]))
      {
         $_SESSION["user_id"] = $session_arr[0];
      }
      else
      {
         $_SESSION["user_id"] = -1;
      }
	  //var_dump($cmd);
  // }
  // else
  // {
     // $fakeCookie = $path."../fakeCookie.txt";
     // if(file_exists($fakeCookie))
    //  {
     //    $id = file_get_contents($fakeCookie);
     //    if(!empty($id))
     //    {
      //      $_SESSION["user_id"] = (int) $id;
     //    }
      //   else
       //     $_SESSION["user_id"] = -1;
    //  }
    //  else
    //     $_SESSION["user_id"] = -1;
  // }
   return $_SESSION["user_id"];
}

?>
