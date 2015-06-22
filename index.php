<html>
  <head>
    <meta charset="utf-8">
    <title>Homepage</title>
  </head>
  <body>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="add_agreement.php">Add Agreement</a>
    <a href="add_building.php">Add Building</a>
    <a href="add_surgery.php">Add Surgery</a>
    <?php
    session_start();

      //if user is logged in print the info
      if(isset($_SESSION['session_key']) && $_SESSION['session_key'] != "")
        echo("Jestes zalogowany jako: ".$_SESSION['email']);
    ?>
  </body>
</html>