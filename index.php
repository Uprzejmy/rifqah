<html>
  <head>
    <title>Homepage</title>
  </head>
  <body>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <?php
      session_start();

      //if user is logged in print the info
      if(isset($_SESSION['key']) && $_SESSION['key'] != "")
        echo("Jestes zalogowany jako: ".$_SESSION['email']);
    ?>
  </body>
</html>