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

          //maybe we shouldn't allow user to check for more than 2 weeks for example, but there is a mess with dates comparison
          //select all surgeries with specified type
          $query = "SELECT surgeries.id as surgery_id, surgeries.name as surgery_name, buildings.name as building_name FROM surgeries JOIN buildings ON surgeries.building_id=buildings.id WHERE type=".$_GET['specialization'];
          $result = mysql_query($query)
            or die("Can't get surgeries info");

          //and fill them into array
          $surgeries = array();
          while($row = mysql_fetch_assoc($result))
          {
            //in the most nested array we will store agreements
            $surgeries[$row['surgery_id']] = array('name' => "Surgery: ".$row['surgery_name']." in: ".$row['building_name']." building", 'agreements' => array());
          }

          //prepare array for dates
          $dates = date_range($_GET['start_date'],$_GET['end_date']);
          foreach($dates as $key=>$value)
          {
            $dates[$key] = $surgeries;
          }

          // select all agreements with every information we have in specified date range
          $query = "SELECT agreements._date as _date, agreements.hour_start as hour_start, agreements.hour_end as hour_end, surgeries.id as surgery_id
            FROM agreements
            JOIN surgeries ON agreements.surgery_id=surgeries.id
            WHERE _date<='".$_GET['end_date']."' AND _date>='".$_GET['start_date']."' AND surgeries.type=".$_GET['specialization']."
            ORDER BY _date, hour_start";

          $result = mysql_query($query)
            or die("Can't get agreements info");

          while($row = mysql_fetch_assoc($result))
          {
            $dates[$row['_date']][$row['surgery_id']]['agreements'][] = array('hour_start' => $row['hour_start'],'hour_end' => $row['hour_end']);
          }

          echo("Every surgery is available from 7:00 to 21:00, there must be at least 15 mnute break between two separate leasings<br/>");
          //print the data
          foreach($dates as $key => $date)
          {
            echo($key.":<br/>");
            foreach($date as $surgery)
            {
              echo("*".$surgery['name'].":<br/>");
              foreach($surgery['agreements'] as $agreement)
              {
                echo("**reserved from: ".$agreement['hour_start']." to: ".$agreement['hour_end']."<br/>");
              }
              echo("<br/>");
            }
            echo("<br/>");
          }

          //uncomment these line to reveal the structure
          // echo("<pre>");
          // print_r($dates);
          // echo("<pre>");
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