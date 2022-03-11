<?php
  include 'connect.php';
  date_default_timezone_set('Asia/Singapore');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8>
		<link rel="shortcut icon" href="#" />
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/mastercss.css">
    <link rel="stylesheet" href="css/peoplecss.css">

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
					 <li><a href="people.php">People</a></li>
					 <li><a href="#">Community</a></li>
					 <li><a href="#">Account Settings</a></li>
					</ul></th></tr>
			</table>
			<hr style="border-top: 0.5px solid #F0EDED; opacity: 0.05; margin-bottom: 0;">
			</div>
		</nav>

    <div id="view">

      <h2>Processional</h2>
      <div class="card">
      <img src="icon/heart.png" width="72" height="72">
      <div class="container">
        <h4><b>Groom</b></h4>
        <p>Albus Weng</p>
        <h4><b>Bride</b></h4>
        <p>Charis Ng Xin Yi</p>
      </div>
</div>
      <h2>Services</h2>
      <h2>Guest Invitation</h2>
    </div>


    </div>

</body>
</html>
