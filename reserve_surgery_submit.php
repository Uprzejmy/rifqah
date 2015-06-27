<?php

  include("connect.php");

  session_start();

  //if there is no data in POST (in reserve_surgery form) fill the message and redirect to reserve_surgery page
  if(!isset($_POST['date']) || ($_POST['date'] == "") ||
    (!isset($_POST['start_hour']) || ($_POST['start_hour'] == "")) ||
    (!isset($_POST['end_hour']) || ($_POST['end_hour'] == "")) ||
    (!isset($_POST['surgery'])))
  {
    $_SESSION['form_error'] = "Fields are empty";
    header('Location: ' . 'reserve_surgery.php');
    die();
  }

  //some validation

  //check if surgery is available in selected time
  $query = "SELECT id FROM agreements WHERE 
    surgery_id = \"".$_POST['surgery']."\" AND 
    date_start<=".$_POST['date']." AND 
    date_end>=".$_POST['date']." AND 
    day_num=DAYOFWEEK(".$_POST['date'].") AND 
    hour_start>=SUBTIME('".$_POST['start_hour']."','00:15') AND 
    hour_end<=ADDTIME('".$_POST['end_hour']."','00:15')";
  echo($query);
  die();
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