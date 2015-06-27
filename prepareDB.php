<?php

  //check if script has been run using console
  if(php_sapi_name() != "cli")
  {
    header('Location: ' . 'index.php');
  }

  //drop existing database to be sure tables doesn't exists at start
  include("connect.php");

  $dropQuery = 'DROP DATABASE '.$dbName;
  mysql_query($dropQuery)
    or die ("Can't drop the database\r\n");

  $createQuery = 'CREATE DATABASE '.$dbName;
  mysql_query($createQuery)
    or die ("Can't create the database\r\n");

  //refresh connection and create tables

  include("connect.php");

  $queries = array
  (
    'CREATE TABLE users (
      id INT AUTO_INCREMENT NOT NULL,
      email VARCHAR(127) NOT NULL, 
      password VARCHAR(127) NOT NULL, 
      surname VARCHAR(127) NOT NULL,
      name VARCHAR(127) NOT NULL,
      session_key VARCHAR(127),
      PRIMARY KEY(id),
      UNIQUE KEY email (email)     
    ) 

    DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci 
    ENGINE = InnoDB    
    ',

    'CREATE TABLE admins (
      id INT AUTO_INCREMENT NOT NULL,
      user_id INT NOT NULL,
      PRIMARY KEY(id),
      UNIQUE KEY user_id (user_id),
      CONSTRAINT admins_user_id FOREIGN KEY (user_id) REFERENCES users (id)
    )

    DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci 
    ENGINE = InnoDB    
    ',

    'CREATE TABLE patients (
      id INT AUTO_INCREMENT NOT NULL,
      user_id INT NOT NULL,
      PRIMARY KEY(id),
      UNIQUE KEY user_id (user_id),
      CONSTRAINT patients_user_id FOREIGN KEY (user_id) REFERENCES users (id)
    )

    DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci 
    ENGINE = InnoDB    
    ',

    'CREATE TABLE doctors (
      id INT AUTO_INCREMENT NOT NULL,
      user_id INT NOT NULL,
      specialization INT NOT NULL,
      PRIMARY KEY(id),
      UNIQUE KEY user_id (user_id),
      CONSTRAINT doctors_user_id FOREIGN KEY (user_id) REFERENCES users (id)
    )

    DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci 
    ENGINE = InnoDB    
    ',

    'CREATE TABLE buildings (
      id INT AUTO_INCREMENT NOT NULL,
      name VARCHAR(127) NOT NULL,
      PRIMARY KEY(id)
    )

    DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci 
    ENGINE = InnoDB    
    ',

    'CREATE TABLE surgeries (
      id INT AUTO_INCREMENT NOT NULL,
      building_id INT NOT NULL,
      type INT NOT NULL,
      name VARCHAR(127) NOT NULL,
      PRIMARY KEY(id),
      CONSTRAINT surgeries_building_id FOREIGN KEY (building_id) REFERENCES buildings (id)
    )

    DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci 
    ENGINE = InnoDB    
    ',

    'CREATE TABLE agreements (
      id INT AUTO_INCREMENT NOT NULL,
      surgery_id INT NOT NULL,
      doctor_id INT NOT NULL,
      date_start DATE NOT NULL,
      date_end DATE NOT NULL,
      day_num INT NOT NULL,
      hour_start TIME NOT NULL,
      hour_end TIME NOT NULL,
      PRIMARY KEY(id),
      CONSTRAINT agreements_surgery_id FOREIGN KEY (surgery_id) REFERENCES surgeries (id),
      CONSTRAINT agreements_doctor_id FOREIGN KEY (doctor_id) REFERENCES doctors (id)
    )

    DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci 
    ENGINE = InnoDB    
    ',
  );

  foreach($queries as $key => $query)
  {
    mysql_query($query)
      or die ($key." Query error, table already exists?\r\n");
  }
  

?>