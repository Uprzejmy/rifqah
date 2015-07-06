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
  //check if user's submitted start later than end
  if($_POST['start_hour'] > $_POST['end_hour'])
  {
    $_SESSION['form_error'] = "end has to be later than start";
    header('Location: ' . 'reserve_surgery.php');
    die();
  }

  //Sugery might be leased only between 7:00 - 21:00
  if($_POST['start_hour'] < "07:00" || $_POST['end_hour'] > "21:00")
  {
    $_SESSION['form_error'] = "Surgery might be reserved only between 7:00 - 21:00";
    header('Location: ' . 'reserve_surgery.php');
    die();
  }

  //minimal lease time is 2 hours
  if($_POST['end_hour'] - $_POST['start_hour'] < 2)
  {
    $_SESSION['form_error'] = "Surgery might be reserved for at least 2 hours";
    header('Location: ' . 'reserve_surgery.php');
    die();
  }

  //check if there is agreement in selected time (15 min collision)
  $query = "SELECT id FROM agreements WHERE 
    surgery_id = \"".$_POST['surgery']."\" AND
    _date='".$_POST['date']."' AND  
    SUBTIME(hour_start,'00:15:00')<='".$_POST['end_hour']."' AND 
    ADDTIME(hour_end,'00:15:00')>='".$_POST['start_hour']."'";

  $result = mysql_query($query)
    or die("Can't get surgery info");
  $row = mysql_fetch_assoc($result);
  if(isset($row['id']))
  {
    $_SESSION['form_error'] = "Surgery isn't available on: ".$_POST['date']." from: ".$_POST['start_hour']." to: ".$_POST['end_hour'];
    header('Location: ' . 'reserve_surgery.php');
    die();
  }

  //data submitted was fine, insert agreement into database
  $query = "INSERT INTO agreements (surgery_id, doctor_id, _date, hour_start, hour_end) 
    VALUES (".$_POST['surgery'].",".$_POST['doctor'].",'".$_POST['date']."','".$_POST['start_hour']."','".$_POST['end_hour']."')";
  mysql_query($query)
    or die("Can't insert agreement's data");

  //everything was fine and the data has been inserted so we can redirect
  header('Location: ' . 'reserve_surgery.php');
  die();


?>