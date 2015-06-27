<html>
  <head>
    <meta charset="utf-8">
    <title>Reserve Surgery</title>
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

        //check if logged user is a doctor
        $query = "SELECT users.id as user_id, users.session_key as user_session_key, doctors.specialization as specialization FROM users JOIN doctors ON users.id=doctors.user_id WHERE users.id = \"".$_SESSION['id']."\"";
        $result = mysql_query($query)
          or die("Can't get user info");
        $row = mysql_fetch_assoc($result);

        //check if session_key is correct for logged user
        if(isset($row['user_session_key']) && ($row['user_session_key'] == $_SESSION['session_key']))
        {
          //if there was any error during submit show appropriate message
          if(isset($_SESSION['form_error']) && $_SESSION['form_error'] != "")
          {
            echo($_SESSION['form_error']."<br/>");
            $_SESSION['form_error'] = "";
          } 

          //doctor can reserve only usg and his specialization's surgery
          if($row['specialization'] == 0)
          {
            $denidedSurgery = 3;
          }
          else
          {
            $denidedSurgery = 1;
          }

          //select all surgeries to make a radio list
          $query = "SELECT id, name FROM surgeries WHERE type<>".$denidedSurgery;
          $result = mysql_query($query)
            or die("Can't get surgeries info");
          $surgeries = array();
          while($row = mysql_fetch_assoc($result))
          {
            $surgeries[] = array($row['id'],$row['name']);
          }

          //display form
          $form = "<form action='reserve_surgery_submit.php' method='POST'>
                surgery: <br/>";

          foreach($surgeries as $surgery)
          {
            $form.= "<input type='radio' name='surgery' value='".$surgery[0]."'>".$surgery[1]."<br/>";
          }
          $form.="
                date: <input type='date' name='date'/><br/>
                start hour:
                <input type='time' name='start_hour'/><br/>
                end hour:
                <input type='time' name='end_hour'/><br/>
                <input type='submit' value='Accept'/><br/>
              </form>";

          echo($form);
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