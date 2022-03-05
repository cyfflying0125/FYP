<?php include 'connect.php';?>

<table id="event" class="scheduled">
  <?php
  if(isset($_GET['date'])) {
    $date = $_GET['date'];
    $dateFormatted = date("Y-m-d", strtotime($date));

    $query="SELECT * FROM calendar WHERE date='$dateFormatted';";
    //echo $query;
    $result = $db->query($query);
    $num_results = $result->num_rows;
    if($num_results == 0) echo " <tr><td>No event scheduled on this day.</td><tr>";

    for($i=0; $i<$num_results; $i++) {
      $row = $result->fetch_assoc();
    ?>
    <tr><td><span class="dot" style="background-color: <?php echo $row['colour'];?>"></span><b><?php echo $row['title'];?></b>
        <hr><?php echo $date, ", "; echo $row['start_time'];?>
        <br><?php echo $row['location'];?>
        <br><?php echo $row['agenda'];?>
      </td></tr>
    <?php
    }
  }
  ?>
</table>
