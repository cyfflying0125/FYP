<?php
@ $db = new mysqli('localhost', 'f32ee', 'f32ee', 'f32ee');
if (mysqli_connect_errno()) {
	echo "Error: Could not connect to database.  Please try again later.";
	exit;
} else {
	//echo "DB Connected <br><br>";
}
?>
