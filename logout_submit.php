<?php

  session_start();

  //clear the session and redirect to homepage
  if(isset($_SESSION))
  {
    $_SESSION = array();
  }

  header('Location: ' . 'index.php', true, 301);
?>