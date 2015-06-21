<?php

  include($_SERVER["DOCUMENT_ROOT"]."/config/parameters.php");

  @mysql_connect($dbHost, $dbUser, $dbPassword)
    or die("There is no connection to MySQL server.\r\n");

  @mysql_select_db($dbName)
    or die("There is no database named ".$dbname."\r\n");

?>