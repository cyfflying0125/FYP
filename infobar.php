<?php
  include 'connect.php';
  //echo $_GET['name'];
  $filePath = $_GET['name'];
  $query = "SELECT * FROM assets WHERE filePath = '$filePath'";
  $result = $db->query($query);
  $num_results = $result->num_rows;
  if ($num_results > 0) {
    $row = $result->fetch_assoc();
    $assetID = $row['assetID'];
    $assetType = $row['assetType'];
    $filePath = $row['filePath'];
    $description = $row['description'];
    $dimension = $row['dimension'];
    $vendor = $row['vendor'];
    $contactPerson = $row['contactPerson'];
    $contactNo = $row['contactNo'];
    $remarks = $row['remarks'];
  }

  $queryQty = "SELECT COUNT(assetID) FROM scene WHERE assetID = '$assetID'";
  $resultQty = $db->query($queryQty);
  $rowQty = $resultQty->fetch_assoc();
  $qty = $rowQty['COUNT(assetID)'];

  $queryALT = "SELECT * FROM assets WHERE assetType = '$assetType'";
  $resultALT = $db->query($queryALT);
  $num_result_ALT = $resultALT->num_rows;

?>
<style>
#infobar table{
  position: absolute;
  text-align: center;
  top: 80px;
  right: 40px;
  width: 260px;
  z-index: 100;
  background: #AD797A;
  border-radius: 4px;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  padding: 12px;
}

#infobar table td {
  background-color: white;
  border-radius: 2px;
  padding: 8px;
}
#infobar table tfoot td {
  background-color: #AD797A;
  border-radius: 2px;
}
#infobar table tbody th {
  background-color: white;
  border-radius: 2px;
  opacity: 80%;
  padding: 8px;
}
#infobar table thead th{
  color: white;
}
</style>
<div id="infobar">
  <table>
  <thead><tr><th colspan="2">Information</th></tr></thead>
  <tbody>
  <tr><th>Item</th>
      <td><?php echo $description;?></td></tr>
  <tr><th>Dimension</th>
      <td><?php echo $dimension;?></td></tr>
  <tr><th>Quantity</th>
          <td><?php echo $qty;?></td></tr>
  <tr><th>Vendor</th>
      <td><?php echo $vendor;?></td></tr>
  <tr><th>Contact</th>
      <td><?php echo $contactPerson, "<br>", $contactNo; ?></td></tr>
  <tr><th>Remarks</th>
      <td><?php if ($remarks == NULL) { echo "-"; } else echo $remarks; ?></td></tr>
  <?php
    if ($num_result_ALT > 1) {


      echo "<tr><th colspan='2'>Alternatives<br>";
      echo "<form action='' method='post'>";
      echo "<input type='hidden' name='action' value='change'/>";
      echo "<select name='alternatives' id='alternatives' onchange='this.form.submit();'>";
      for ($i=0; $i<$num_result_ALT; $i++) {
        $rowALT = $resultALT->fetch_assoc();
        $id = $rowALT['assetID'];
        $des = $rowALT['description'];
        if($id == $assetID) {
          echo "<option value= '$id' selected>$des</option>";
        } else echo "<option value= '$id'>$des</option>";
      }
      echo "</select></form></th></tr>";
    }
  ?>

  </tbody>
  </table>
</div>
