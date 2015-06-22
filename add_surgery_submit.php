<?php

  include("connect.php");

  session_start();

  //if there is no data in POST (in add_agreement form) fill the message and redirect to add_agreement page
  if(!isset($_POST['name']) || ($_POST['name'] == "") ||
    (!isset($_POST['type'])) ||
    (!isset($_POST['building'])))
  {
    $_SESSION['form_error'] = "Fields are empty";
    header('Location: ' . 'add_surgery.php');
    die();
  }

  //some validation

  //check if surgery with submitted name exists
  $query = "SELECT id FROM surgeries WHERE name = \"".$_POST['name']."\"";
  $result = mysql_query($query)
    or die("Can't get surgery info");
  $row = mysql_fetch_assoc($result);
  if(isset($row['id']))
  {
    $_SESSION['form_error'] = "There is already a surgery with name: ".$_POST['name'];
    header('Location: ' . 'add_surgery.php');
    die();
  }

  //data submitted was fine, insert building into database
  $query = "INSERT INTO surgeries (name,type,building_id) VALUES (\"".$_POST['name']."\",".$_POST['type'].",".$_POST['building'].")";
  echo($query);
  mysql_query($query)
    or die("Can't insert surgery's data");

  //everything was fine and the data has been inserted so we can redirect
  header('Location: ' . 'add_surgery.php');
  die();


?>