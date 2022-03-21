<?php
  include 'connect.php';
  date_default_timezone_set('Asia/Singapore');

  if (isset($_GET['category'])) {
    $title = $_GET['category'];
  }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8>
		<link rel="shortcut icon" href="#" />
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="css/mastercss.css">
    <link rel="stylesheet" href="css/budgetcss.css">
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

					 <li><a href="#">Account Settings</a></li>
					</ul></th></tr>
			</table>
			<hr style="border-top: 0.5px solid #F0EDED; opacity: 0.05; margin-bottom: 0;">
			</div>
		</nav>

    <div id="leftcol">
    <div id="budgetTable">
      <h2>Budget Table: <?php echo $title;
      if ($title != "overview") {?>
        <input class = "pri-btn" type="submit" value="Save Changes >" style="float: right; margin:0 0 12px;">
      <?php }?>
      </h2>
      <table id="budgetList">

      <?php if ($title == "overview") {
        ?>
        <tr><th>Category</th>
          <th>Total Estimated($)</th>
          <th>Actual Spending($)</th>
          <th>Difference($)</th>
        </tr>

        <?php
        $query = "SELECT category, SUM(estimate), SUM(actual) FROM budget GROUP BY category";
        $result = $db->query($query);
        $num_results = $result->num_rows;
        $sumEstimate = 0.00;
        $sumActual = 0.00;
        for($i=0; $i<$num_results; $i++) {
          $row = $result->fetch_assoc();
          $category = $row['category'];
          $estimate = $row['SUM(estimate)'];
          $actual = $row['SUM(actual)'];
          $sumEstimate += $estimate;
          $sumActual += $actual;
          ?>

          <tr onclick = "location.href='budget.php?category=<?php echo $category?>'"
              id="row<?php echo $category;?>"><td><?php echo $category;?></td>
          <td><?php echo $row['SUM(estimate)'];?></td>
          <td><?php echo $row['SUM(actual)'];?></td>
          <td><?php $difference = $row['SUM(estimate)'] - $row['SUM(actual)'];
            if($difference != $row['SUM(estimate)'])
            echo number_format((float)$difference, 2, '.', ''); ?></td>
          </tr>
          <?php
        }
        ?>
        <tr><th align="right">Total</th>
          <th align="left"><?php echo number_format((float)$sumEstimate, 2, '.', '');?></th>
          <th align="left"><?php
          if ($sumActual != 0) {
            echo number_format((float)$sumActual, 2, '.', '');
          } else echo "0.00";?></th>
          <th align="left"><?php if ($sumActual != 0) echo $sumEstimate - $sumActual;?></th>
        </tr>
      </table>
      <h2><br>Total Spending ($)<div style="float:right; margin-right:12px;"><span class="dot">&nbsp;</span>
        <small style="font-size: 14px;">Overspent</small></div></h2>
      <table id="chart">

        <?php
        $query = "SELECT category, SUM(estimate), SUM(actual) FROM budget GROUP BY category ORDER BY SUM(actual) DESC";
        $result = $db->query($query);
        $num_results = $result->num_rows;

        for($i=0; $i<$num_results; $i++) {
          $row = $result->fetch_assoc();
          $sumA = $row['SUM(actual)'];
          $percentage = number_format((float)($sumA/$sumActual), 2, '.', '')*100;
          $sumE = $row['SUM(estimate)'];
          if ($i == 0 ) $max = $sumA;

          if ($sumA > 0) {
            if ($sumA > $sumE) { //if Exceeds
              $width =floor($sumE / $max * 568);
              $exceed = floor(($sumA - $sumE) / $max * 568);

            } else {
              $width =floor(( $sumA / $max ) * 568);
              $exceed = 0;
            }
          } else  {
            $width = 0;
            $exceed = 0;
          }

          ?>
          <tr><th><?php echo $row['category'];?></th>
            <td><span class = "bar" style="width:<?php echo $width;?>px;">&nbsp;</span><span class = "exceed" style="width:<?php echo $exceed;?>px;"><?php
              if($sumA > $sumE) echo $sumA - $sumE;?></span>
            <?php echo "<b>", $row['SUM(actual)'],"</b>";
                  if($percentage != 0) echo " [",$percentage,"%]";?>
                </td></tr>
          <?php
        }
        ?>

      </table>
        <?php

      } else {
        ?>
        <tr><th>Item</th>
          <th>Vendor</th>
          <th>Estimated($)</th>
          <th>Actual($)</th>
          <th>Difference($)</th>
        </tr>

        <?php
        $query = "SELECT * FROM budget WHERE category = '$title'";

        $result = $db->query($query);
        $num_results = $result->num_rows;
        $sumEstimate = 0.00;
        $sumActual = 0.00;
        for($i=0; $i<$num_results; $i++) {
          $row = $result->fetch_assoc();
          $estimate = $row['estimate'];
          $actual = $row['actual'];
          $sumEstimate += $estimate;
          $sumActual += $actual;
          $idE = "E" .$i;
          $idA = "A" .$i;
          $idD = "D" .$i;


        ?>
          <tr><td contenteditable="true"><?php echo $row['subcategory']?></td>
          <td contenteditable="true"><?php echo $row['vendor']?></td>
          <td contenteditable="true" onblur = "calculateE(<?php echo $i?>);" class ="estimate" id="<?php echo $idE;?>">
            <?php echo $row['estimate']?></td>
          <td contenteditable="true" onblur = "calculateA(<?php echo $i?>);" class = "actual" id="<?php echo $idA;?>">
            <?php echo $row['actual']?></td>
          <td id="<?php echo $idD;?>"><?php $difference = $estimate - $actual;
            if($difference != $estimate)
            echo number_format((float)$difference, 2, '.', ''); ?></td>
        </tr>
        <?php
        }
        ?>
        <tr><th align="right" colspan="2">Total</th>
          <th align="left" id = "totalE"><?php echo number_format((float)$sumEstimate, 2, '.', '');?></th>
          <th align="left" id = "totalA"><?php
          if ($sumActual != 0) {
            echo number_format((float)$sumActual, 2, '.', '');
          } else echo "0.00";?></th>
          <th align="left" id = "totalD"><?php if ($sumActual != 0) echo $sumEstimate - $sumActual;?></th>
        </tr>
      </table>
        <?php
      }

        ?>

    </div>
    </div>

    <div id="rightcol">
      <div id="selector">
      <h2>Directory</h2>
      <ul id="directory">
        <li><a href='budget.php?category=overview'><b>Overview</b></a></li>
        <?php
        $query = "SELECT DISTINCT category FROM budget";
        $result = $db->query($query);
        $num_results = $result->num_rows;

        for($i=0; $i<$num_results; $i++) {
          $row = $result->fetch_assoc();
          $category = $row['category'];
          echo "<li id='$category'><a href='budget.php?category=$category'>$category</a></li>";
        }
        ?>
      </ul>
      <input class = "pri-btn" type="submit" value="+ Add New"  style="margin:16px 38%;">

      </div>
    </div>
    </div>
    <script type="text/javascript" src="js/budgetCalculator.js"></script>
</body>
</html>
 
