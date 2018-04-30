<?php

 define('ENVIRONMENT', 'production');
//define('ENVIRONMENT', 'development');

if (ENVIRONMENT == 'production') {
   define("DB_HOST", "localhost");
   define("DB_USER", "mm5_securesc");
   define("DB_PASS", '5UAfLFlh');
   define("DB_NAME", 'securesc_mm5');

   define("CALC_HOST_NAME", $_SERVER['HTTP_HOST']);

} else {
   //define("DB_HOST", "localhost");
   //define("DB_USER", "schletterdev_mm5");
   //define("DB_PASS", '3edcvfr4');
   //define("DB_NAME", 'schletter_pvmini');
   //define("DB_NAME", 'schletter_pvmini');
 define("DB_HOST", "localhost");
 define("DB_USER", "schletterdev_mm5");
 define("DB_PASS", '3edcvfr4');
 define("DB_NAME", 'schletterdev_mm5');

//   define("DB_USER", DB_NAME);
//   define("DB_PASS", 'J@3edcvfr4');
   
   if(!defined("USE_CACHE"))
      define("USE_CACHE", false);
   define("CALC_HOST_NAME", "dev.secure.schletter.us");
}

?>
