<html>
  <head>
    <title>Add Agreement</title>
  </head>
  <body>
    <a href="/login.php">Login</a>
    <a href="/register.php">Register</a>
    <?php

      //we need to use server web path
      include($_SERVER["DOCUMENT_ROOT"]."/config/connect.php");

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
          echo("Your user's data is valid<br/>");

          if(isset($_SESSION['form_error']) && $_SESSION['form_error'] != "")
          {
            //if there was any error during submit show appropriate message
            echo($_SESSION['form_error']."<br/>");
            $_SESSION['form_error'] = "";
          } 

          //display form
          echo("<form action='add_agreement_submit.php' method='POST'>
                doctor's email: <input type='text' name='doctor_email'/><br/>
                surgery: 
                <input type='radio' name='surgery' value='internist' checked>internist
                <input type='radio' name='surgery' value='usg'>usg
                <input type='radio' name='surgery' value='gynecologist'>gynecologist<br/>
                day: 
                <input type='radio' name='day' value='1' checked>Monday
                <input type='radio' name='day' value='2'>Tuesday
                <input type='radio' name='day' value='3'>Wednesday
                <input type='radio' name='day' value='4'>Thursday
                <input type='radio' name='day' value='5'>Friday
                <input type='radio' name='day' value='6'>Saturday
                <input type='radio' name='day' value='7'>Sunday<br/>
                start: 
                <input type='text' name='start_hour'/>:
                <input type='text' name='start_minute'/><br/>
                end: 
                <input type='text' name='end_hour'/>:
                <input type='text' name='end_minute'/><br/>
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