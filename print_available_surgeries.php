<html>
  <head>
    <title>Print Available Surgeries</title>
  </head>
  <body>
    <a href="index.php">Homepage</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <?php

      include("dateRange.php");

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
          //select all surgeries with specified type
          $query = "SELECT id, name FROM surgeries WHERE type=".$_GET['specialization'];
          $result = mysql_query($query)
            or die("Can't get surgeries info");

          //and fill them into array
          $surgeries = array();
          while($row = mysql_fetch_assoc($result))
          {
            $surgeries[$row['id']] = $row['name'];
          }

          //prepare array for dates, every day has it's index
          $dates = date_range($_GET['start_date'],$_GET['end_date']);


          // select all agreements with every information we have in specified date range
          $query = "SELECT agreements.id as agreement_id, agreements._date as _date, agreements.hour_start as hour_start, agreements.hour_end as hour_end, 
            surgeries.id as surgery_id, surgeries.name as surgery_name, surgeries.type as surgery_type,
            buildings.id as building_id, buildings.name as bulding_name
            FROM agreements 
            JOIN surgeries ON agreements.surgery_id=surgeries.id 
            JOIN buildings ON surgeries.building_id=buildings.id 
            WHERE _date<='".$_GET['end_date']."' AND _date>='".$_GET['start_date']."' 
            ORDER BY _date";
        $result = mysql_query($query)
          or die("Can't get agreements info");


          echo("<br/>");
          echo($query);
          echo("<br/>");

          echo("You're a doctor<br/>");
          if($_GET['specialization'] == 0)
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