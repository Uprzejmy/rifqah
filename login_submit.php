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


  //if there is wrong password submitted fill the message and redirect to login page
  if($_POST['password'] != $row['password'])
  {
    $_SESSION = array();
    $_SESSION['login_error'] = "Niepoprawne haslo";
    header('Location: ' . 'login.php');
    die();
  }
  else
  {
    //everything is ok, user's data exists so let him log in and redirect to homepage
    $_SESSION['key'] = 'klucz'.$_POST['id'];
    $_SESSION['id'] = $_POST['id'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['surname'] = $_POST['surname'];

    header('Location: ' . 'index.php');
    die();
  }

?>