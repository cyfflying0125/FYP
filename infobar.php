<?php
  include 'connect.php';
  echo $_GET['name'];
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
  <thead><tr><th>Infomation</th></tr></thead>
  <tbody>
  <tr><th>Item</th>
      <td>Rounded Banquet Table</td></tr>
  <tr><th>Dimension</th>
      <td>White 60"x60"</td></tr>
  <tr><th>Quantity</th>
          <td>8</td></tr>
  <tr><th>Vendor</th>
      <td>Hillcrest Hotel</td></tr>
  <tr><th>Contact</th>
      <td>Mr Brandon Sim <br>+65 6242 1777</td></tr>
  <tr><th>Last Update</th>
      <td>5 Jan 2022, 5pm</td></tr>
  <tr><th colspan="2">Alternatives</th></tr>
  </tbody>
  <tfoot>
    <tr><td colspan="2">
      <button type="button" name="button">Option 1</button>
      <button type="button" name="button">Option 2</button></td></tr>
  </tfoot>
  </table>
</div>
