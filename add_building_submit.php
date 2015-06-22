<?php

  include("connect.php");

  session_start();

  //if there is no data in POST (in add_agreement form) fill the message and redirect to add_agreement page
  if(!isset($_POST['name']) || ($_POST['name'] == ""))
  {
    $_SESSION['form_error'] = "Fields are empty";
    header('Location: ' . 'add_building.php');
    die();
  }

  //some validation

  //check if building with submitted name exists
  $query = "SELECT id FROM buildings WHERE name = \"".$_POST['name']."\"";
  $result = mysql_query($query)
    or die("Can't get building info");
  $row = mysql_fetch_assoc($result);
  
  if(isset($row['id']))
  {
    $_SESSION['form_error'] = "There is already a building with name: ".$_POST['name'];
    header('Location: ' . 'add_building.php');
    die();
  }

  //data submitted was fine, insert building into database
  $query = "INSERT INTO buildings (name) VALUES (\"".$_POST['name']."\")";
  mysql_query($query)
    or die("Can't insert bulding's data");

  //everything was fine and the data has been inserted so we can redirect
  header('Location: ' . 'add_building.php');
  die();


?>