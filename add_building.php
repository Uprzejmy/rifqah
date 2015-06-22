<html>
  <head>
    <title>Add Building</title>
  </head>
  <body>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="add_agreement.php">Add Agreement</a>
    <a href="add_building.php">Add Building</a>
    <a href="add_surgery.php">Add Surgery</a>
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

          //display form
          echo("<form action='add_building_submit.php' method='POST'>
                name: 
                <input type='text' name='name'><br/>
                <input type='submit' value='Accept'/><br/>
              </form>");
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