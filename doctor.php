<html>
  <head>
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
        echo("You're logged in as: ".$_SESSION['email']."<br/>");

        include("connect.php");

        //check if logged user is an patient
        $query = "SELECT users.id as user_id, users.session_key as user_session_key, doctors.specialization as specialization FROM users JOIN doctors ON users.id=doctors.user_id WHERE users.id = \"".$_SESSION['id']."\"";
        $result = mysql_query($query)
          or die("Can't get user info");
        $row = mysql_fetch_assoc($result);

        //check if session_key is correct for logged user
        if(isset($row['user_session_key']) && ($row['user_session_key'] == $_SESSION['session_key']))
        {
          echo("You're a doctor<br/>");
          if($row['specialization'] == 0)
          {
            echo
            ("
              Your specialization is Internist<br/>
              <form action='print_available_surgeries.php' method='GET'>
                <input type='hidden' name='specialization' value='1'>
                date start: <input type='date' name='start_date'/><br/>
                date end: <input type='date' name='end_date'/><br/>
                <input type='submit' value='Print internist surgeries'/><br/>
              </form>
            ");
          }
          else
          {
            echo
            ("
              Your specialization is Gynecologist<br/>
              <form action='print_available_surgeries.php' method='GET'>
                <input type='hidden' name='specialization' value='3'>
                date start: <input type='date' name='start_date'/><br/>
                date end: <input type='date' name='end_date'/><br/>
                <input type='submit' value='Print gynecologist surgeries'/><br/>
              </form>
            ");
          }
          echo("
            <form action='print_available_surgeries.php' method='GET'>
              <input type='hidden' name='specialization' value='2'>
              date start: <input type='date' name='start_date'/><br/>
              date end: <input type='date' name='end_date'/><br/>
              <input type='submit' value='Print USG surgeries'/><br/>
            </form>
          ");
          echo("<a href='reserve_surgery.php'>Reserve Surgery</a>");
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