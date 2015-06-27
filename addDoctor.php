<?php

  //check if script has been run using console
  if(php_sapi_name() != "cli")
  {
    header('Location: ' . 'index.php');
  }

  include("connect.php");

  //create user for doctor
  $query = "INSERT INTO users (email, password, name, surname) VALUES ('doctor', '".md5('doctor')."', 'doctor', 'doctor')";
  mysql_query($query)
    or die("Can't create doctor");

  //select id of doctor user
  $query = "SELECT id FROM users WHERE email = 'doctor'";
  $result = mysql_query($query)
    or die("Can't create doctor");
  $row = mysql_fetch_assoc($result);
  $doctorId = $row['id'];

  //add doctor into doctors table
  $query = "INSERT INTO doctors (user_id, specialization) VALUES (".$doctorId.", 0)";
  $result = mysql_query($query)
    or die("Can't create doctor");

?>