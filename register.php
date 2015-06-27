<html>
  <head>
    <title>Register</title>
  </head>
  <body>
    <a href="index.php">Homepage</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <?php 

      session_start();

      if(isset($_SESSION['session_key']) && $_SESSION['session_key'] != "")//if user is already logged in let him logout manually first
      {
        echo("You're logged in as: ".$_SESSION['name'].' '.$_SESSION['surname'].' '.$_SESSION['email']);
        echo('<form action="logout_submit.php" method="POST">
                <input type="submit" value="Wyloguj"/>
              </form>');
      }
      else
      {    
        if(isset($_SESSION['registration_error']))//if there was any error during login show appropriate message
        {
          echo($_SESSION['registration_error']);
          $_SESSION = array();
        }  

        //display login form
        echo('<form action="register_submit.php" method="POST">
                email: <input type="text" name="email"/><br/>
                password: <input type="password" name="password"/><br/>
                repeat password: <input type="password" name="password2"/><br/>
                name: <input type="name" name="name"/><br/>
                surname: <input type="surname" name="surname"/><br/>
                register as: 
                <input type="radio" name="role" value="patient" checked>Patient
                <input type="radio" name="role" value="internist">Doctor Internist
                <input type="radio" name="role" value="gynecologist">Doctor Gynecologist
                <input type="submit" value="Register"/>
              </form>');
      }
    ?>
  </body>
</html>