<?php
$roll=$_POST['email'];
include('../db.php');
$stmt = $conn->prepare('SELECT email from temp_students where email=?');
$stmt->bind_param("s", $roll);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
	echo "Email Already Exists !";
} else{
	$stmtq = $conn->prepare('SELECT email from student where email=?');
	$stmtq->bind_param("s", $roll);
	$stmtq->execute();
	$resultq = $stmtq->get_result();
	if ($resultq->num_rows > 0) {
		echo "Email Already Registered !";
	} else {
		$stmtqc = $conn->prepare('SELECT email from login where email=?');
		$stmtqc->bind_param("s", $roll);
		$stmtqc->execute();
		$resultqc = $stmtqc->get_result();
		if ($resultqc->num_rows > 0) {
			echo "Email Already Exists !";
		}
	}
}
?>