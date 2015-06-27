<html>
  <head>
    <meta charset="utf-8">
    <title>Homepage</title>
  </head>
  <body>
    <a href="index.php">Homepage</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <?php
      session_start();

      //if user is logged in print the info
      if(isset($_SESSION['session_key']) && $_SESSION['session_key'] != "")
      {
        echo("Jestes zalogowany jako: ".$_SESSION['email']."<br/>");
        echo
        ("
          <a href='patient.php'>Patient</a><br/>
          <a href='doctor.php'>Doctor</a><br/>
          <a href='admin.php'>Admin</a><br/>
        ");
      }
    ?>
  </body>
</html>