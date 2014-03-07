<?php

//LIVE on GoDaddy Database Constants
define("DB_SERVER", "plusdelta.db.8540667.hostedresource.com");
define("DB_USER", "plusdelta");
define("DB_PASS", "Plu54Delta!");
define("DB_NAME", "plusdelta");

/*   
// localhost Database Constants
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_NAME", "plusdelta");
 
  */


// 1. Create a database connection
$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
if (!$connection) {
	die("Database connection failed: " . mysql_error());
}

// 2. Select a database to use 
$db_select = mysql_select_db(DB_NAME,$connection);
if (!$db_select) {
	die("Database selection failed: " . mysql_error());
}
?>
