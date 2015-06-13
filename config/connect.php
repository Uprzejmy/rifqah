<?php

  include("config/parameters.php");

  @mysql_connect($dbHost, $dbUser, $dbPassword)
    or die('There is no connection to MySQL server.');

  @mysql_select_db($dbName)
    or die('There is no database named '.$dbname);

?>