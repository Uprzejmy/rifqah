<?php

  include("config/connect.php");

  $query = ('CREATE TABLE users (
            id INT AUTO_INCREMENT NOT NULL,
            email VARCHAR(255) NOT NULL, 
            password VARCHAR(255) NOT NULL, 
            surname VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id),
            UNIQUE KEY email (email)     
          ) 

          DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci 
          ENGINE = InnoDB
          
        ');

  $result = mysql_query($query)
    or die ('Query error');

?>