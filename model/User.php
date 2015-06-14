<?php

include("config/connect.php");

class User
{
  private $id;

  private $email;

  private $password;

  private $name;

  private $surname;

  public function __construct()
  {
  }

  public function fetch($id)
  {
    $query = 'SELECT id, email, password, name, surname FROM users WHERE id = '.$id;

    $result = mysql_query($query)
      or die("Can't get user info");

    $row = mysql_fetch_assoc($result);
  
    $this->id = $row['id'];
    $this->email = $row['email'];
    $this->password = $row['password'];
    $this->name = $row['name'];
    $this->surname = $row['surname'];
  }

  public function printUser()
  {
    echo("Id: ".$this->id);
    echo("Email: ".$this->email);
    echo("Password: ".$this->password);
    echo("Name: ".$this->name);
    echo("Surname: ".$this->surname);
  }

  public function isUser()
  {
    if($this->id)
      return true;

    return false;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getSurname()
  {
    return $this->surname;
  }

}

?>