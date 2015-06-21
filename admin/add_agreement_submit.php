<?php

  include($_SERVER["DOCUMENT_ROOT"]."/config/connect.php");

  session_start();

  //if there is no data in POST (in add_agreement form) fill the message and redirect to add_agreement page
  if(!isset($_POST['doctor_email']) || ($_POST['doctor_email'] == "") || 
    (!isset($_POST['surgery'])) || 
    (!isset($_POST['day'])) || 
    (!isset($_POST['start_hour'])) || ($_POST['start_hour'] == "") || 
    (!isset($_POST['start_minute'])) || ($_POST['start_minute'] == "") || 
    (!isset($_POST['end_hour'])) || ($_POST['end_hour'] == "") || 
    (!isset($_POST['end_minute'])) || ($_POST['end_minute'] == ""))
  {
    $_SESSION['form_error'] = "Fields are empty";
    header('Location: ' . 'add_agreement.php');
    die();
  }

  //some validation

  //$time = $hours*60+$minutes just to make comparision easier
  $startTime = $_POST['start_hour']*60 + $_POST['start_minute'];
  $endTime = $_POST['end_hour']*60 + $_POST['end_minute'];

  //check if user's submitted start later than end
  if($startTime > $endTime)
  {
    $_SESSION['form_error'] = "end has to be later than start";
    header('Location: ' . 'add_agreement.php');
    die();
  }

  //Sugery might be leased only between 7:00 - 21:00
  if($startTime < 7*60 || $endTime > 21*60)
  {
    $_SESSION['form_error'] = "Surgery might be leased only between 7:00 - 21:00";
    header('Location: ' . 'add_agreement.php');
    die();
  }

  //minimal lease time is 2 hours
  if($endTime - $startTime < 2*60)
  {
    $_SESSION['form_error'] = "Surgery might be leased for at least 2 hours";
    header('Location: ' . 'add_agreement.php');
    die();
  }

  //check if doctor with submitted email exists

  $query = "SELECT users.id FROM users JOIN doctors ON users.id=doctors.user_id WHERE email = \"".$_POST['doctor_email']."\"";
  $result = mysql_query($query)
    or die("Can't get user info");
  $row = mysql_fetch_assoc($result);
  
  if(!isset($row['id']))
  {
    $_SESSION['form_error'] = "There is no doctor with email: ".$_POST['doctor_email'];
    header('Location: ' . 'add_agreement.php');
    die();
  }

  //zoptymalizowac zapytanie o to czy admin probuje sie dostac.

  // if($_POST['end_hour'].$_POST['end_minute'] - )

  // $query = "SELECT id, email, password, name, surname FROM users WHERE email = \"".$_POST['email']."\"";

  // $result = mysql_query($query)
  //   or die("Can't get user info");

  // $row = mysql_fetch_assoc($result);

  // //check if user with submitted email exists
  // if(!isset($row['id']))
  // {
  //   $_SESSION = array();
  //   $_SESSION['login_error'] = "There is no user with ".$_POST['email']." login";
  //   header('Location: ' . 'login.php');
  //   die();
  // }

  // //if there is wrong password submitted fill the message and redirect to login page
  // if(md5($_POST['password']) != $row['password'])
  // {
  //   $_SESSION = array();
  //   $_SESSION['login_error'] = "Password is not correct";
  //   header('Location: ' . 'login.php');
  //   die();
  // }
  // else
  // {
  //   $date = new DateTime();
  //   $session_key = md5($_POST['email'].$date->getTimestamp());
  //   //everything is ok, user submitted valid data create new session_key, log him in and redirect to homepage
  //   $query = "UPDATE users SET session_key='".$session_key."' WHERE id='".$row['id']."'";
  //   echo($query);
  //   $result = mysql_query($query)
  //   or die("Can't register the user");

  //   //everything is ok, user's data exists so let him log in and redirect to homepage
  //   $_SESSION['session_key'] = $session_key;
  //   $_SESSION['id'] = $row['id'];
  //   $_SESSION['email'] = $_POST['email'];
  //   $_SESSION['password'] = $row['password'];
  //   $_SESSION['name'] = $row['name'];
  //   $_SESSION['surname'] = $row['surname'];

  //   header('Location: ' . 'index.php');
  //   die();
  // }

?>