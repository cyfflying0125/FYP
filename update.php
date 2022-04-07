<?php
include 'connect.php';

if (isset($_POST['page'])) $page = $_POST['page'];
//echo "<br>".$_POST['page'];

if (isset($_POST['editArray'])) {
  $editArray = $_POST['editArray'];
  foreach($editArray as $key => $innerArray) {
    //print_r($innerArray);
    $itemID = $innerArray[0];
    $col = $innerArray[1];
    $value = str_replace('<br>','',$innerArray[2]); //Extract values from the sub-array
    $subquery = "UPDATE $page SET $col = '$value' WHERE itemID = $itemID;";//Update query for the current element
    $db->query($subquery);//Submit to Database
    //echo $subquery."<br>";
  }
  $db -> close();
}

?>
