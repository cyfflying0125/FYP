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
    <script type="text/javascript" src="js/guestManager.js"></script>

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
          <li><a href="budget.php">Budget</a></li>
          <li><a href="people.php?viewmode=grid">People</a></li>
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
      <h2>Processional<a href="javascript:addNewProcessional();"><img id="processionalIcon" src="icon/add.png" height="24" width="24" style="opacity:0.4; margin-left:8px; vertical-align:text-top;"></a>
        <div id="fullList" style="font-size: 18px;">
        <a id="gridView" href="people.php?viewmode=grid">Grid View</a> |
        <a id="ListView" href="people.php?viewmode=list">Full List</a></div>
      </h2>
      <br>
      <div id="grid">
      <?php
      $query = "SELECT MAX(people.group) FROM people";
      $result = $db->query($query);
      $row = $result->fetch_assoc();
      $max = $row['MAX(people.group)'] + 1;

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


      for ($j=1; $j<$max; $j++) { //for each group, print a card
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
      <form method="post" action="update.php">
      <div class="card" id="newProcessional" style="display:none;">
      <div class="container">
        <span class="number">...</span>
        <input type="hidden" name="max" value="<?php echo $max;?>">
        <input type="hidden" name="formName" value="processional">
        <h4><b><input required class="title" name="newRole" type="text" value="" placeholder="New Title"></b></h4>
        <p><input class="subtitle" name="newName" type="text" value="" placeholder="Name"></p>
        <p><button class="pri-btn" onclick="submit()" style="margin: 0; border-radius: 50%;">OK</button></p>
      </div>
      </div>
      </form>
      </div>
      <h2>Services<a href="javascript:addNewService();"><img id="serviceIcon" src="icon/add.png" height="24" width="24" style="opacity:0.4; margin-left:8px; vertical-align:text-top;"></a></h2>

      <?php
      $query = "SELECT * FROM people WHERE category = 'Service' ORDER BY role";
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
      <form method="post" action="update.php">
       <div class="card" id= "newService" style="height:140px; display: none; height: auto">
       <div class="container">
         <input type="hidden" name="formName" value="service">
         <h4><b><input required class="title" name="newRole" type="text" value="" placeholder="New Title"></b></h4>
         <p><input class="subtitle" name="newName" type="text" value="" placeholder="Name"></p>
         <p><button class="pri-btn" onclick="submit()" style="margin: 0; border-radius: 50%;">OK</button></p>
        </div>
      </div>
    </form>

      <h2>SEATING ARRANGEMENT</h2>

      <?php

      $query = "SELECT DISTINCT tableNumber FROM people ORDER BY tableNumber ASC";
      $result = $db->query($query);
      $num_results = $result->num_rows;
      $tableArray = [];
      for($i=0; $i<$num_results; $i++) {
        $row = $result->fetch_assoc();
        $table = $row['tableNumber'];
        if($table != null) {
          echo "<table id='guestTable'>";
          echo "<tr><th>TABLE ".$table."</th></tr>";
          echo "<tr><td>";
          $subquery = "SELECT name FROM people WHERE tableNumber = '".$table."'";
          //echo $subquery;
          $subresult = $db->query($subquery);
          $sub_num_results = $subresult->num_rows;
          for ($j=0; $j<$sub_num_results; $j++) {
            $sub_row = $subresult->fetch_assoc();
            echo $sub_row['name']."<br>";
          }
          echo "</td></tr>";
          echo "</table>";
        }
      }
      $query = "SELECT name FROM people WHERE tableNumber IS NULL";
      $result = $db->query($query);
      $num_results = $result->num_rows;
      ?>
      <table id='guestTable'>
        <tr><th>Not Yet Allocated</th></tr>
        <tr><td>
        <?php
          if($num_results == 0) {
            echo "-";
          } else {
            for($i=0; $i<$num_results; $i++) {
              $row = $result->fetch_assoc();
              echo $row['name'].'<br>';
            }
          }
        ?>
        </td></tr>
      </table>

    <?php
    } else if ($_GET['viewmode'] == 'list') {
      ?>
      <h2><div id="fullList" style="font-size: 18px;">
        <a id="gridView" href="people.php?viewmode=grid">Grid View</a> |
        <a id="ListView" href="people.php?viewmode=list">Full List</a></div>
      </h2>
      <div id="overlay">
        <form method="post" action="">
        <table>
          <tr><th>Name</th><td><input type="text" name="name" value=""></td></tr>
          <tr><th>Category</th><td><input type="text" name="category" value=""></td></tr>
          <tr><th>Role</th><td><input type="text" name="role" value=""></td></tr>
          <tr><th>Table Number</th><td><input type="text" name="tableNo" value=""></td></tr>
          <tr><th>Confirmation</th><td><input type="text" name="confirmation" value=""></td></tr>
          <tr><th>Remarks</th><td><input type="text" name="remarks" value=""></td></tr>
        </table>

        <button class = "pri-btn" type="submit" style="float:right;margin-right: 12px;">Update</button>
        <button class = "sec-btn" onclick="close();" style="float:right;">Cancel</button>
        </form>
      </div>
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
        <th></th>
        </tr>";

      for($i=0; $i<$num_results; $i++) {
        $row = $result->fetch_assoc();
        ?>
        <tr>
          <td><?php echo $row['name'];?></td>
          <td><?php echo $row['category'];?></td>
          <td><?php echo $row['role'];?></td>
          <td><?php echo $row['tableNumber'];?></td>
          <td><?php echo $row['confirmation'];?></td>
          <td><?php echo $row['remarks'];?></td>
          <td><a href="javascript:openEdit('<?php echo $row['name'];?>');">
          <img src="icon/edit.png" width="16" height="16" style="opacity:0.5; margin: 0 4px;"></a>
            <a onclick="return confirm('Delete this row?');" href="update.php?delete=<?php echo $row['name'];?>&table=people">
            <img src="icon/delete.png" width="16" height="16" style="opacity:0.5; margin: 0 4px;"></a></td>
        </tr>
        <?php
      }
      echo "</table>";


    }?>
    </div>
    </div>

</body>
</html>
