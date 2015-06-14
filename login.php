<html>
  <head>
    <title>Login</title>
  </head>
  <body>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <?php 

      session_start();

      if(isset($_SESSION['key']) && $_SESSION['key'] != "")//if user is already logged in let him logout manually first
      {
        echo('Jestes juz zalogowany jako: '.$_SESSION['name'].' '.$_SESSION['surname'].' '.$_SESSION['email']);
        echo('<form action="logout_submit.php" method="POST">
                <input type="submit" value="Wyloguj"/>
              </form>');
      }

      else
      {    
        if(isset($_SESSION['login_error']))//if there was any error during login show appropriate message
        {
          echo($_SESSION['login_error']);
          unset($_SESSION['login_error']);
        }  

        //display login form
        echo('<form action="login_submit.php" method="POST">
                email: <input type="text" name="email"/><br/>
                password: <input type="password" name="password"/><br/>
                <input type="submit" value="Zaloguj"/>
              </form>');
      }
    ?>
  </body>
</html>