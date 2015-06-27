<html>
  <head>
    <meta charset="utf-8">
    <title>Doctor</title>
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

        include("connect.php");

        //check if logged user is an patient
        $query = "SELECT users.id as user_id, users.session_key as user_session_key, doctors.specialization as specialization FROM users JOIN doctors ON users.id=doctors.user_id WHERE users.id = \"".$_SESSION['id']."\"";
        $result = mysql_query($query)
          or die("Can't get user info");
        $row = mysql_fetch_assoc($result);

        //check if session_key is correct for logged user
        if(isset($row['user_session_key']) && ($row['user_session_key'] == $_SESSION['session_key']))
        {
          echo("You're logged in as a doctor<br/>");
          if($row['specialization'] == 0)
          {
            echo("Your specialization is Internist<br/>");
          }
          else
          {
            echo("Your specialization is Gynecologist<br/>");
          }
        }
        else
        {
          echo("You're not a doctor<br/>");
        }
      }
      else
      {
        echo("You're not logged in<br/>");
      }
    ?>
  </body>
</html>