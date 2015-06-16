<?php

  include("config/connect.php");

  session_start();

  //if data in POST (in registration form) is not complete fill the message and redirect to registration page
  if((!isset($_POST['email'])) || 
    ($_POST['email'] == "") || 
    (!isset($_POST['password'])) || 
    ($_POST['password'] == "") || 
    (!isset($_POST['password2'])) || 
    ($_POST['password2'] == "") || 
    (!isset($_POST['name'])) || 
    ($_POST['name'] == "") || 
    (!isset($_POST['surname'])) || 
    ($_POST['surname'] == ""))
  {
    $_SESSION = array();
    $_SESSION['registration_error'] = "Brakuje danych";
    header('Location: ' . 'register.php');//simply redirect user to another page
    die();
  }

  //check if user with submitted email already exists (email is unique)
  $query = "SELECT id FROM users WHERE email = \"".$_POST['email']."\"";

  $result = mysql_query($query)
    or die("Can't get user info");

  $row = mysql_fetch_assoc($result);

  if($row['id'])
  {
    $_SESSION = array();
    $_SESSION['registration_error'] = "Adres email jest zajęty";
    header('Location: ' . 'register.php');
    die();
  }

  //check if passwords are correct
  if($_POST['password'] != $_POST['password2'])
  {
    $_SESSION = array();
    $_SESSION['registration_error'] = "Podane hasła się nie zgadzają";
    header('Location: ' . 'register.php');
    die();
  }
  
  //everything is ok, user submitted valid data register him, log him in and redirect to homepage
  $query = "INSERT INTO users (email, password, name, surname) VALUES ('".$_POST['email']."', '".md5($_POST['password'])."', '".$_POST['name']."', '".$_POST['surname']."')";
  $result = mysql_query($query)
    or die("Can't register the user");

  //not the perfect code, just to get id of new user to log him in
  $query = "SELECT id FROM users WHERE email = \"".$_POST['email']."\"";
  $result = mysql_query($query)
    or die("Can't get user info");
  $row = mysql_fetch_assoc($result);

  if($_POST['role'] == "doctor")
  {
    //Create query to insert Patient data into database
    $query = "INSERT INTO doctors (user_id) VALUES (".$row['id'].")";
  }
  else
  {
    //Create query to insert Doctor data into database
    $query = "INSERT INTO patients (user_id) VALUES (".$row['id'].")";
  }
  //execute role query
  mysql_query($query)
    or die("Can't get user info");

  //set session data - log user in
  $_SESSION['key'] = 'klucz'.$row['id'];
  $_SESSION['id'] = $row['id'];
  $_SESSION['email'] = $_POST['email'];
  $_SESSION['password'] = md5($_POST['password']);
  $_SESSION['name'] = $_POST['name'];
  $_SESSION['surname'] = $_POST['surname'];

  header('Location: ' . 'index.php');
  die();

?>