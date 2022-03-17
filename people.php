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
    <link rel="stylesheet" type="text/css" href="css/mastercss.css">
    <link rel="stylesheet" type="text/css" href="css/peoplecss.css">

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
					 <li><a href="people.php?viewmode=grid">People</a></li>
					 <li><a href="#">Community</a></li>
					 <li><a href="#">Account Settings</a></li>
					</ul></th></tr>
			</table>
			<hr style="border-top: 0.5px solid #F0EDED; opacity: 0.05; margin-bottom: 0;">
			</div>
		</nav>

    <div id="view">

      <?php
        if(isset($_GET['viewmode']) && $_GET['viewmode'] == 'grid' ) {
          ?>
      <h2>Processional<div id="fullList" style="font-size: 18px;">
        <a id="gridView" href="people.php?viewmode=grid">Grid View</a> |
        <a id="ListView" href="people.php?viewmode=list">Full List</a></div>
      </h2>
      <br>
      <div id="grid">
      <?php
      echo "<script>document.getElementById('gridView').style.fontWeight = 'bold';</script>";
      $query = "SELECT * FROM people WHERE category = 'Processional' ORDER BY people.group ASC";
      $result = $db->query($query);
      $num_results = $result->num_rows;

      $groupArray = [];
      $roleArray = [];
      $nameArray = [];
      for($i=0; $i<$num_results; $i++) {
        $row = $result->fetch_assoc();
        $group = $row['group'];
        $role = $row['role'];
        $name = $row['name'];
        array_push($groupArray, $group);
        array_push($roleArray, $role);
        array_push($nameArray, $name);
      }


      for ($j=1; $j<7; $j++) { //for each group, print a card
        ?>
        <div class="card">
        <div class="container">
        <span class="number"><?php echo $j;?></span>
        <?php
        foreach($groupArray as $key => $element) { //search array
          if ($element == $j) { //if group number found
            if ($roleArray[$key] != $titlePrinted) { //if role title not yet printed
              echo "<h4><b>";
              echo $roleArray[$key];
              echo "</b></h4>";
            }
            echo "<p>";
            echo $nameArray[$key];
            echo "</p>";

            $titlePrinted = $roleArray[$key];
          }
        }
        ?>
        </div>
        </div>
      <?php
      }
      ?>
      </div>
      <h2>Services</h2>

      <?php
      $query = "SELECT * FROM people WHERE category = 'Service'";
      $result = $db->query($query);
      $num_results = $result->num_rows;
      for($i=0; $i<$num_results; $i++) {
        $row = $result->fetch_assoc();
        ?>
        <div class="card" style="height:140px; display: inline-block; ">
        <div class="container">
          <h4><b><?php echo $row['role'];?></b></h4>
          <p><?php echo $row['name'];?></p>
        </div>
      </div>

        <?php
      }
       ?>

      <h2>Guest Invitation</h2>

      <?php
      $query = "SELECT name, tableNumber FROM people WHERE category = 'Guest' ORDER BY tableNumber ASC";
      $result = $db->query($query);
      $num_results = $result->num_rows;
      $guestArray = [];
      for($i=0; $i<$num_results; $i++) {
        $row = $result->fetch_assoc();
        $guestName = $row['name'];
        $table = $row['tableNumber'];
        $guestArray += ["$guestName" => $table];
      }

      $tablePrinted = null;
      $isTablePrinted = false;
      foreach($guestArray as $key => $element) {
        if($element != $tablePrinted) {
          if($isTablePrinted == true) {
            echo "</td></tr>";
            echo "</table>";
          }
          echo "<table id='guestTable'>";
          echo "<tr><th>TABLE ";
          echo $element;
          echo "</th></tr>";
          echo "<tr><td>";
          echo $key;
          $tablePrinted = $element;
          $isTablePrinted = true;
        } else echo "<br>", $key;
      }

    } else if ($_GET['viewmode'] == 'list') {
      ?>
      <h2><div id="fullList" style="font-size: 18px;">
        <a id="gridView" href="people.php?viewmode=grid">Grid View</a> |
        <a id="ListView" href="people.php?viewmode=list">Full List</a></div>
      </h2>
      <?php
      echo "<script>document.getElementById('ListView').style.fontWeight = 'bold';</script>";
      $query = "SELECT * FROM people ORDER BY tableNumber ASC, people.group";
      $result = $db->query($query);
      $num_results = $result->num_rows;
      echo "<table id='attendance'>";
      echo "<tr>
        <th>Name</th>
        <th>Category</th>
        <th>Role</th>
        <th>Table Number</th>
        <th>Confirmation</th>
        <th>Remarks</th>
        </tr>";
      for($i=0; $i<$num_results; $i++) {
        $row = $result->fetch_assoc();
        ?>
        <tr>
          <td><div contenteditable><?php echo $row['name'];?></div></td>
          <td><?php echo $row['category'];?></td>
          <td><?php echo $row['role'];?></td>
          <td><?php echo $row['tableNumber'];?></td>
          <td><?php echo $row['confirmation'];?></td>
          <td><?php echo $row['remarks'];?></td>
        </tr>
        <?php
      }
      echo "</table>";


    }?>
    </div>
    </div>

</body>
</html>
