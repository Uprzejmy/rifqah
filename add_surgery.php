<html>
  <head>
    <title>Add Surgery</title>
  </head>
  <body>
    <a href="index.php">Homepage</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <?php

      include("connect.php");

      session_start();

      //check if there is any session
      if(isset($_SESSION['session_key']) && $_SESSION['session_key'] != "")
      {
        echo("You're logged in as: ".$_SESSION['name']." ".$_SESSION['surname']." ".$_SESSION['email']."<br />");

        //we want to select user with his admin id. If no data is returned, user is not valid or user is not admin
        $query = "SELECT users.id as user_id, users.session_key as user_session_key, admins.id as admin_id FROM users JOIN admins ON users.id=admins.user_id WHERE users.id = \"".$_SESSION['id']."\"";
        $result = mysql_query($query)
          or die("Can't get user info");
        $row = mysql_fetch_assoc($result);

        //check if session_key is correct for logged user
        if(isset($row['user_session_key']) && $row['user_session_key'] == $_SESSION['session_key'])
        {
          if(isset($_SESSION['form_error']) && $_SESSION['form_error'] != "")
          {
            //if there was any error during submit show appropriate message
            echo($_SESSION['form_error']."<br/>");
            $_SESSION['form_error'] = "";
          } 

          $query = "SELECT id, name FROM buildings";
          $result = mysql_query($query)
            or die("Can't get buildings info");
          $buildings = array();
          while($row = mysql_fetch_assoc($result))
          {
            $buildings[] = array($row['id'],$row['name']);
          }

          //display form
          $form = "<form action='add_surgery_submit.php' method='POST'>
                name: 
                <input type='text' name='name'><br/>
                Type:<br/>
                <input type='radio' name='type' value=1 checked>internist
                <input type='radio' name='type' value=2>usg
                <input type='radio' name='type' value=3>gynecologist<br/>
                Building:<br/>";
          foreach($buildings as $building)
          {
            $form.= "<input type='radio' name='building' value='".$building[0]."' checked>".$building[1]."";
          }
          $form.="<br/><input type='submit' value='Accept'/><br/></form>";
                
          echo($form);
        }
        else
          echo("You're not an admin");

      }
      else
      {    
        //user is not logged in
        echo("You're not an admin");
      }
    ?>
  </body>
</html>