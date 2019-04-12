<?php
error_reporting(0);
//fuck_logic
$stmt = $conn->prepare('SELECT * FROM login where roll = ?');
$stmt->bind_param('s', $roll);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
	$val_type=$row['type'];
}
if($val_type=="1"){echo '<script>window.parent.location = "index.php"</script>';}

?>