<html>
  <head>
    <meta charset="utf-8">
    <title>Get Surgeries</title>
  </head>
  <body>
    <a href="index.php">Homepage</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <?php
      session_start();
      echo("Script isn't ready yet");
      die();

      //if user is logged in print the info
      if(isset($_SESSION['session_key']) && $_SESSION['session_key'] != "")
      {
        echo("You're logged in as: ".$_SESSION['email']."<br/>");

        include("connect.php");

        //check if logged user is a doctor
        $query = "SELECT users.id as user_id, users.session_key as user_session_key, doctors.specialization as specialization FROM users JOIN doctors ON users.id=doctors.user_id WHERE users.id = \"".$_SESSION['id']."\"";
        $query = "SELECT * FROM agreements JOIN surgeries ON agreements.surgery_id=surgeries.id JOIN buildings ON surgeries.building_id=buildings.id";
        $result = mysql_query($query)
          or die("Can't get user info");
        $row = mysql_fetch_assoc($result);

        //check if session_key is correct for logged user
        if(isset($row['user_session_key']) && ($row['user_session_key'] == $_SESSION['session_key']))
        {
          //improove permissions in free time
          $query = "SELECT surgeries.id as surgery_id, surgeries.type as surgery_type, surgeries.name as surgery_name, buildings.id as building_id, buildings.name as building_name FROM surgeries JOIN buildings ON surgeries.building_id=buildings.id";
          echo("You're a doctor<br/>");
          if($_GET['type'] == 0)
          {
            echo
            ("
              Your specialization is Internist<br/>
              <a href='get_available_surgeries/1'>Print internist surgeries</a>
              <a href='get_available_surgeries/2'>Print USG surgeries</a>
            ");
          }
          else
          {
            echo
            ("
              Your specialization is Gynecologist<br/>
              <a href='get_available_surgeries/3'>Print gynecologist surgeries</a>
              <a href='get_available_surgeries/2'>Print USG surgeries</a>
            ");
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