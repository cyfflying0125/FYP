<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8>
		<link rel="shortcut icon" href="#" />
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/mastercss.css">
    <link rel="stylesheet" href="css/calendarcss.css">
  	<title>Wedding Planner</title>
		<script type="text/javascript" src="js/buttonManager.js"></script>

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

    <div id="calendar">
      <div class="month">
         <i class="prev"><img src="icon/back.png" width="32" height="32" style=""> </i>
         <div class="date">
           <h1>March</h1>
           <p></p>
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
    <div id="schedule">
      <h2>Event Scheduled</h2>
      <table class = "scheduled">
        <tr><td><span class="dot"></span><b>Meeting with Photographer</b>
                <hr>12:00pm
                <br>Starbucks (Star Vista)
                <br>Discuss pre-wedding photoshoot
                </td></tr>
        <tr><td><span class="dot"></span><b>Meeting with Photographer</b>
                <hr>12:00pm
                <br>Starbucks (Star Vista)
                <br>Discuss pre-wedding photoshoot
                </td></tr>
      </table>
      <h2>Add a New Event</h2>
      <form action="/form/submit" method = "post">
      <table class="addNew">
        <tr><th>Title* </th><td><input type="text" required></td></tr>
        <tr><th>Colour </th><td><input id = "colorpicker" type="color" value ="#bbbbbb"></tr>
        <tr><th>Date</th><td>DD-MMM-YYYY</td></tr>
        <tr><th>Start Time</th><td><input type="time" value="13:00"></td></tr>
        <tr><th>Agenda </th><td><input type="textarea"></td></tr>
        <tfoot><tr><td colspan="2"><input class = "sec-btn" type="reset" value="Clear">
          <input class = "pri-btn" type="submit" value="+ Add to Calendar"></td></tr></tfoot>
      </table>
      </form>

    </div>
    </div>
<script type="text/javascript" src="js/calendar.js"></script>


</body>
</html>
