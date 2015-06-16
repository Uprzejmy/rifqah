<?php

  include("config/connect.php");

  session_start();

  //if there is no data in POST (in login form) fill the message and redirect to login page
  if(!isset($_POST['email']) || ($_POST['email'] == "") || (!isset($_POST['password'])) || ($_POST['password'] == ""))
  {
    $_SESSION = array();
    $_SESSION['login_error'] = "Brak danych";
    header('Location: ' . 'login.php');//simply redirect user to another page
    die();
  }

  $query = "SELECT id, email, password, name, surname FROM users WHERE email = \"".$_POST['email']."\"";

  $result = mysql_query($query)
    or die("Can't get user info");

  $row = mysql_fetch_assoc($result);

  //check if user with submitted email exists
  if(!isset($row['id']))
  {
    $_SESSION = array();
    $_SESSION['login_error'] = "Nie ma takiego użytkownika";
    header('Location: ' . 'login.php');
    die();
  }

  //if there is wrong password submitted fill the message and redirect to login page
  if(md5($_POST['password']) != $row['password'])
  {
    $_SESSION = array();
    $_SESSION['login_error'] = "Niepoprawne haslo";
    header('Location: ' . 'login.php');
    die();
  }
  else
  {
    $date = new DateTime();
    $session_key = md5($_POST['email'].$date->getTimestamp());
    //everything is ok, user submitted valid data create new session_key, log him in and redirect to homepage
    $query = "UPDATE users SET session_key='".$session_key."' WHERE id='".$row['id']."'";
    echo($query);
    $result = mysql_query($query)
    or die("Can't register the user");

    //everything is ok, user's data exists so let him log in and redirect to homepage
    $_SESSION['session_key'] = $session_key;
    $_SESSION['id'] = $row['id'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $row['password'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['surname'] = $row['surname'];

    header('Location: ' . 'index.php');
    die();
  }

?>