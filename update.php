<?php
include 'connect.php';

if (isset($_POST['editArray'])) {
  $editArray = $_POST['editArray'];

  //print_r($editArray);
  //echo "<br>".$_POST['page'];

} else echo "Error - Unable to Update the Database. Please Try Again Later.";

?>
