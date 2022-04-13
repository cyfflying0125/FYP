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
  if(isset($_GET['table'])) {
    $query = "DELETE FROM people WHERE name ='".$_GET['delete']."'";
    $db->query($query);
    header('Location: people.php?viewmode=list');

  } else {
    $query = "SELECT COUNT(category) FROM budget WHERE category ='".$_GET['category']."'";
    $result = $db->query($query);
    $row = $result->fetch_assoc();

    $query = "DELETE FROM budget WHERE itemID =".$_GET['delete'];
    $db->query($query);
    if($row['COUNT(category)'] == 1) {
      header('Location: budget.php');
    } else header('Location: budget.php?category='.$_GET['category']);
  }
}


 if (isset($_POST['formName']) && $_POST['formName'] == 'service') {
   $newRole = $_POST['newRole'];
   $newName = $_POST['newName'];
   $query = "INSERT INTO people (`name`, `category`, `role`)
    VALUES ('$newName','Service','$newRole')";
    $db->query($query);
    echo $query;

    header('Location: people.php?viewmode=grid');

 } else if (isset($_POST['formName']) && $_POST['formName'] == 'processional') {
   $newRole = str_replace("'","\'",$_POST['newRole']);
   $newName = str_replace("'","\'",$_POST['newName']);

   $query = "SELECT people.group FROM people WHERE role = '$newRole'";
   echo $query;
   $result = $db->query($query);
   $num_results = $result->num_rows;
   if($num_results == 0) {
     $group = $_POST['max'];
   } else {
     $row = $result->fetch_assoc();
     $group = $row['group'];
   }

    $query = "INSERT INTO people (`name`, `category`, `role`,`group`)
     VALUES ('$newName','Processional','$newRole',$group)";
     $db->query($query);
     //echo $query;
    header('Location: people.php?viewmode=grid');
   }


?>
