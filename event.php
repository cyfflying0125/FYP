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
    <form>
    <tr><td><span class="dot" style="background-color: <?php echo $row['colour'];?>"></span>
      <b><?php echo $row['title'];?></b>
      <a href="#" onclick ="<?php
        echo "editEvent('",$row['eventID'],"','",$row['title'],"','",$row['date'],"','",$row['start_time'],"','",$row['colour'],"','",$row['location'],"','",$row['agenda'],"')";
        ?>; return false; "><img src="icon/edit.png" alt="Edit" width="16" height="16" style="margin-left: 8px; opacity:0.6;"></a>
      <a onclick="return confirm('Delete this event?');" href="calendar.php?delete=<?php echo $row['eventID'];?>">
        <img src="icon/delete.png" alt="Delete" width="16" height="16" style="opacity:0.6;"></a>

        <hr><?php echo $date, ", "; echo $row['start_time'];?>
        <br><?php echo $row['location'];?>
        <br><?php echo $row['agenda'];?>
      </td></tr>
    </form>
    <?php
    }
  }
  ?>
</table>
