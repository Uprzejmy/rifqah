<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <a href="add_agreement.php">Add Agreement</a>
    <a href="add_building.php">Add Building</a>
    <a href="add_surgery.php">Add Surgery</a>
    <?php 

      session_start();

      if(isset($_SESSION['session_key']) && $_SESSION['session_key'] != "")//if user is already logged in let him logout manually first
      {
        echo('Jestes juz zalogowany jako: '.$_SESSION['name'].' '.$_SESSION['surname'].' '.$_SESSION['email']);
        echo('<form action="logout_submit.php" method="POST">
                <input type="submit" value="Log out"/>
              </form>');
      }
      else
      {    
        if(isset($_SESSION['login_error']))//if there was any error during login show appropriate message
        {
          echo($_SESSION['login_error']);
          $_SESSION = array();
        }  

        //display login form
        echo('<form action="login_submit.php" method="POST">
                email: <input type="text" name="email"/><br/>
                password: <input type="password" name="password"/><br/>
                <input type="submit" value="Log in"/>
              </form>');
      }
    ?>
  </body>
</html>