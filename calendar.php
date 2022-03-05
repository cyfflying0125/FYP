<?php
  include 'connect.php';
  date_default_timezone_set('Asia/Singapore');

  if (!empty($_POST['title'])){
    $title = $_POST['title'];
    $date = $_POST['currentDate'];
    $dateFormatted = date("Y-m-d", strtotime($date));
    $startTime = $_POST['eventTime'];
    $colour = $_POST['colour'];
    $location = $_POST['location'];
    $agenda = $_POST['agenda'];

    $queryInsert = "INSERT INTO calendar(`title`, `date`, `start_time`, `colour`, `location`, `agenda`)
      VALUES ('$title' ,'$dateFormatted','$startTime','$colour','$location','$agenda');";
    //echo $queryInsert;
    $result = $db->query($queryInsert);
    echo '<script>alert("Event Added Successfully!")</script>';
  }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8>
		<link rel="shortcut icon" href="#" />
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/mastercss.css">
    <link rel="stylesheet" href="css/calendarcss.css">
  	<title>Wedding Planner</title>

	</head>
	<body>

    <div id="wrapper">
		<nav>
			<div style="background-image: url('icon/TopBanner.png');">
			<table>
				<tr>
					<td><img src="icon/profile.png" alt="profile.png" width="88" height="88" style="background:white; border-radius: 44px;"></td>

				</tr>
				<tr><td>Albus & Charis</td>
				<th><ul>
					 <li><a href="index.php">Venue</a></li>
					 <li><a href="calendar.php">Calendar</a></li>
					 <li><a href="budget.html">Budget</a></li>
					 <li><a href="#">Community</a></li>
					 <li><a href="#">Account Settings</a></li>
					</ul></th></tr>
			</table>
			<hr style="border-top: 0.5px solid #F0EDED; opacity: 0.05; margin-bottom: 0;">
			</div>
		</nav>

    <div id="leftcol">
    <div id="calendar">
      <div class="month">
         <i class="prev"><img src="icon/back.png" width="32" height="32"> </i>
         <div class="date">
           <h1>March</h1>

         </div>
         <i class="next"><img src="icon/back.png" width="32" height="32" style="transform:rotate(180deg);"> </i>
       </div>
       <hr>
       <div class="weekdays">
         <div>Sun</div>
         <div>Mon</div>
         <div>Tue</div>
         <div>Wed</div>
         <div>Thu</div>
         <div>Fri</div>
         <div>Sat</div>
       </div>
       <div class="days"></div>
    </div>
    <div id = list>
      <h2>UPCOMING</h2>
      <hr style="border-top: 1px solid #F0EDED; opacity: 0.5; margin-bottom: 24px;">
      <table>
        <?php
          $query = "SELECT * FROM calendar WHERE date >= CURDATE() ORDER BY date ASC, start_time";
          $result = $db->query($query);
          $num_results = $result->num_rows;
          $datePrinted = null;
          if($num_results == 0) {
            echo " <tr><td>No event scheduled yet.</td><tr>";
          } else {
            for($i=0; $i<$num_results; $i++) {
              $row = $result->fetch_assoc();
        ?>
              <tr><th>
                <?php $date = $row['date'];
                if($date != $datePrinted) {
                  $dateFormatted = date("j M Y", strtotime("$date"));
                  echo $dateFormatted;
                }
                $datePrinted = $date;  ?></th>

                <td><span class="dot" style="background-color: <?php echo $row['colour'];?>"></span>
                <?php
                $time = $row['start_time'];
                $timeFormatted = date("g:i A", strtotime("$time"));
                echo $timeFormatted," <b> - ";
                echo $row['title'],"</b><br>";
                echo $row['location'],"<br>";
                echo $row['agenda'];
                ?></td>
              </tr>
        <?php
            }
          }
        ?>
      </table>
    </div>
  </div>

    <div id="schedule">
      <h2>Event Scheduled</h2>
      <table class = "scheduled" id = "event"></table>
      <h2>Add a New Event</h2>
      <form action="calendar.php" method = "post">
      <table class="addNew">
        <tr><th>Title* </th><td><input type="text" name="title" required></td></tr>
        <tr><th>Colour </th><td><input id = "colorpicker" name="colour" type="color" value ="#bbbbbb"></tr>
        <tr><th>Date</th><td><input id="currentDate" name="currentDate" value='<?php echo date("d M Y");?>' onfocus="this.blur();"></td></tr>
        <tr><th>Start Time</th><td><input type="time" name="eventTime"></td></tr>
        <tr><th>Location</th><td><input type="text" name="location"></td></tr>
        <tr><th>Agenda </th><td><input type="textarea" name="agenda"></td></tr>
        <tfoot><tr><td colspan="2"><input class = "sec-btn" type="reset" value="Clear">
          <input class = "pri-btn" type="submit" value="+ Add to Calendar"></td></tr></tfoot>
      </table>
      </form>
    </div>

    </div>
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="js/scheduler.js"></script>
</body>
</html>
