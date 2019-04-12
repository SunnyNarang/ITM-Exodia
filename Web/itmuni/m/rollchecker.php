<?php
$roll=$_POST['roll'];
include('../db.php');
$stmt = $conn->prepare('SELECT roll from temp_students where roll=?');
$stmt->bind_param("s", $roll);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
	echo "Roll Already Exists !";
} else{
	$stmtq = $conn->prepare('SELECT roll from student where roll=?');
	$stmtq->bind_param("s", $roll);
	$stmtq->execute();
	$resultq = $stmtq->get_result();
	if ($resultq->num_rows > 0) {
		echo "Roll Already Registered !";
	} else {
		$stmtqz = $conn->prepare('SELECT roll from login where roll=?');
		$stmtqz->bind_param("s", $roll);
		$stmtqz->execute();
		$resultqz = $stmtqz->get_result();
		if ($resultqz->num_rows > 0) {
			echo "Roll Already Exists !";
		}
	}
}
?>