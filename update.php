<?php
include 'connect.php';

//TO SAVE TABLE EDITS
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

//TO ADD NEW CATEGORIES
if(isset($_POST['newItem'])) {
  $subcategory = $_POST['newItem'];

  if($_POST['other']== '') {
    $category=ucwords($_POST['newCategory']);
  } else $category = ucwords($_POST['other']);

  $vendor= ucwords($_POST['newVendor']);
  $est = $_POST['newEstimate'];
  $act = $_POST['newActual'];

  $query = "INSERT INTO budget(`category`, `subcategory`, `vendor`, `estimate`, `actual`)
    VALUES ('$category','$subcategory','$vendor','$est', '$act')";
  //echo $query;
  $db->query($query);
  header('Location: budget.php?category='.$category);

}

//TO DELETE A ROW
if(isset($_GET['delete'])) {
  $query = "SELECT COUNT(category) FROM budget WHERE category ='".$_GET['category']."'";
  $result = $db->query($query);
  $row = $result->fetch_assoc();

  $query = "DELETE FROM budget WHERE itemID =".$_GET['delete'];
  $db->query($query);
  if($row['COUNT(category)'] == 1) {
    header('Location: budget.php');
  } else header('Location: budget.php?category='.$_GET['category']);
}
?>
