<?php

  include("connect.php");

  session_start();

  //if there is no data in POST (in add_agreement form) fill the message and redirect to add_agreement page
  if(!isset($_POST['doctor_email']) || ($_POST['doctor_email'] == "") || 
    (!isset($_POST['surgery'])) || 
    (!isset($_POST['start_date'])) || ($_POST['start_date'] == "") || 
    (!isset($_POST['end_date'])) || ($_POST['end_date'] == "") ||
    (!isset($_POST['day'])) || 
    (!isset($_POST['start_hour'])) || ($_POST['start_hour'] == "") ||
    (!isset($_POST['end_hour'])) || ($_POST['end_hour'] == ""))
  {
    $_SESSION['form_error'] = "Fields are empty";
    header('Location: ' . 'add_agreement.php');
    die();
  }

  //some validation

  //check if user's submitted start later than end
  if($_POST['start_hour'] > $_POST['end_hour'])
  {
    $_SESSION['form_error'] = "end has to be later than start";
    header('Location: ' . 'add_agreement.php');
    die();
  }

  //Sugery might be leased only between 7:00 - 21:00
  if($_POST['start_hour'] < "07:00" || $_POST['end_hour'] > "21:00")
  {
    $_SESSION['form_error'] = "Surgery might be leased only between 7:00 - 21:00";
    header('Location: ' . 'add_agreement.php');
    die();
  }

  //minimal lease time is 2 hours
  if($_POST['end_hour'] - $_POST['start_hour'] < 2)
  {
    $_SESSION['form_error'] = "Surgery might be leased for at least 2 hours";
    header('Location: ' . 'add_agreement.php');
    die();
  }

  //check if doctor with submitted email exists
  $query = "SELECT doctors.id FROM users JOIN doctors ON users.id=doctors.user_id WHERE email = \"".$_POST['doctor_email']."\"";
  $result = mysql_query($query)
    or die("Can't get user info");
  $row = mysql_fetch_assoc($result);
  
  if(!isset($row['id']))
  {
    $_SESSION['form_error'] = "There is no doctor with email: ".$_POST['doctor_email'];
    header('Location: ' . 'add_agreement.php');
    die();
  }

  $doctorId = $row['id'];

  //check if there is 15 min space between two separated leasings
  //select all agreements with collision in dates
  $query = "SELECT id FROM agreements WHERE 
    date_start<'".$_POST['end_date']."' AND 
    date_end>'".$_POST['start_date']."' AND 
    day_num=".$_POST['day']." AND
    hour_start>=SUBTIME('".$_POST['start_hour']."','00:15') AND
    hour_end<=ADDTIME('".$_POST['end_hour']."','00:15')";
  $result = mysql_query($query)
    or die("Can't get agreement info");
  $row = mysql_fetch_assoc($result);

  if(isset($row['id']))
  {
    $_SESSION['form_error'] = "There is collision with another leasing";
    header('Location: ' . 'add_agreement.php');
    die();
  }

  //data submitted was fine, insert agreement into database
  $query = "INSERT INTO agreements (surgery_id, doctor_id, date_start, date_end, day_num, hour_start, hour_end) 
    VALUES (1,".$doctorId.",'".$_POST['start_date']."','".$_POST['end_date']."',".$_POST['day'].",'".$_POST['start_hour']."','".$_POST['end_hour']."')";
  mysql_query($query)
    or die("Can't insert agreement's data");

  //everything was fine and the data has been inserted so we can redirect
  header('Location: ' . 'add_agreement.php');
  die();


?>