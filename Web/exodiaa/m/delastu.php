<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
$postedroll=$_POST['roll'];
$postedroll=htmlspecialchars($postedroll, ENT_QUOTES, 'UTF-8');

	    $stmtq = $conn->prepare('INSERT INTO `temp_students`(`name`, `roll`, `email`, `dob`, `f_name`, `f_mob`, `address1`, `address2`, `city`, `phone`, `branch`, `course`, `sem`) (select student.name, student.roll, student.email, student.dob, student.f_name, student.f_mob, student.address1, student.address2, student.city, student.phone, class.branch, class.course, class.sem from student inner join class on student.class_id=class.id where roll= ?)');
		$stmtq->bind_param("s", $postedroll);
		if($stmtq->execute()){
			$stmtz = $conn->prepare('delete from attendance where roll = ?');
			$stmtz->bind_param("s", $stu_roll);
			$stmtz->execute();
			$stmta = $conn->prepare('delete from student where roll = ?');
			$stmta->bind_param("s", $postedroll);
			$stmta->execute();
		}

?>