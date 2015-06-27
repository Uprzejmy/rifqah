<?php

  //check if script has been run using console
  if(php_sapi_name() != "cli")
  {
    header('Location: ' . 'index.php');
  }

  include("connect.php");

  //create user for patient
  $query = "INSERT INTO users (email, password, name, surname) VALUES ('patient', '".md5('patient')."', 'patient', 'patient')";
  mysql_query($query)
    or die("Can't create patient");

  //select id of patient user
  $query = "SELECT id FROM users WHERE email = 'patient'";
  $result = mysql_query($query)
    or die("Can't create patient");
  $row = mysql_fetch_assoc($result);
  $patientId = $row['id'];

  //add patient into patients table
  $query = "INSERT INTO patients (user_id) VALUES (".$patientId.")";
  $result = mysql_query($query)
    or die("Can't create patient");

?>