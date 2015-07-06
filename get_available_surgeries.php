<html>
  <head>
    <title>Get Surgeries</title>
  </head>
  <body>
    <a href="index.php">Homepage</a>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
    <?php
      session_start();
      // echo("Script isn't ready yet");
      // die();

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

        $_POST['end_date'] = "2015-01-01";
        $_POST['start_date'] = "2015-01-01";

        //check if session_key is correct for logged user
        if(isset($row['user_session_key']) && ($row['user_session_key'] == $_SESSION['session_key']))
        {
          //improove permissions in free time
          $query = "SELECT surgeries.id as surgery_id, surgeries.type as surgery_type, surgeries.name as surgery_name, buildings.id as building_id, buildings.name as building_name FROM surgeries JOIN buildings ON surgeries.building_id=buildings.id";
          
          // $query = "SELECT * FROM agreements  WHERE agreements.date_start>=".$_POST['start_date']."";
          $query = "SELECT agreements.id as agreement_id, agreements.date_start as date_start, agreements.date_end as date_end, agreements.hour_start as hour_start, agreements.hour_end as hour_end, agreements.week_day as day
            surgeries.id as surgery_id, surgeries.name as surgery_name, surgeries.type as surgery_type,
            buildings.id as building_id, buildings.name as bulding_name
            FROM agreements 
            JOIN surgeries ON agreements.surgery_id=surgeries.id 
            JOIN buildings ON surgeries.building_id=buildings.id 
            WHERE date_start<='".$_POST['end_date']."' AND date_end>='".$_POST['start_date']."' 
            ORDER BY date_start";
          // $result = mysql_query($query)
          //   or die("Can't get agreements info");
          // $dates = array();
          // while($row = mysql_fetch_assoc($result))
          // {
          //   $dates[$row['']] = array($row['id'],$row['name']);
          // }

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