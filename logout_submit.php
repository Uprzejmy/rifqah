<?php

  include("connect.php");

  session_start();

  $query = "UPDATE users SET session_key='' WHERE session_key='".$_SESSION['session_key']."'";
  mysql_query($query)
    or die("Can't get user info");

  //clear the session and redirect to homepage
  if(isset($_SESSION))
  {
    $_SESSION = array();
  }

  header('Location: ' . 'index.php');
?>