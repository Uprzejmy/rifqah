<?php

  include("config/connect.php");

  //create user for admin
  $query = "INSERT INTO users (email, password, name, surname) VALUES ('admin', '".md5('admin')."', 'admin', 'admin')";
  mysql_query($query)
    or die("Can't create admin");

  //select id of admin user
  $query = "SELECT id FROM users WHERE email = 'admin'";
  $result = mysql_query($query)
    or die("Can't create admin");
  $row = mysql_fetch_assoc($result);
  $adminId = $row['id'];

  //add admin to admin tables
  $query = "INSERT INTO admins (user_id) VALUES (".$adminId.")";
  $result = mysql_query($query)
    or die("Can't create admin");

?>