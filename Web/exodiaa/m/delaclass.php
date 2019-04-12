<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
if(!$_POST['class_id']){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
$postedclass_id=$_POST['class_id'];
echo $postedclass_id=htmlspecialchars($postedclass_id, ENT_QUOTES, 'UTF-8');


	$stmts = $conn->prepare('select roll from student where class_id = ?');
	$stmts->bind_param("s", $postedclass_id);
	$stmts->execute();
	$results = $stmts->get_result();
	if ($results->num_rows > 0) {
		while($rows = $results->fetch_assoc()) {
	   $stu_roll=$rows['roll'];
	    $stmtq = $conn->prepare('INSERT INTO `temp_students`(`name`, `roll`, `email`, `dob`, `f_name`, `f_mob`, `address1`, `address2`, `city`, `phone`, `branch`, `course`, `sem`) (select student.name, student.roll, student.email, student.dob, student.f_name, student.f_mob, student.address1, student.address2, student.city, student.phone, class.branch, class.course, class.sem from student inner join class on student.class_id=class.id where roll= ?)');
		$stmtq->bind_param("s", $stu_roll);
		if($stmtq->execute()){
			$stmta = $conn->prepare('delete from student where roll = ?');
			$stmta->bind_param("s", $stu_roll);
			$stmta->execute();
			$stmtz = $conn->prepare('delete from attendance where roll = ?');
			$stmtz->bind_param("s", $stu_roll);
			$stmtz->execute();
			$stmt = $conn->prepare('delete from class where id = ?');
			$stmt->bind_param("s", $postedclass_id);
			$stmt->execute();
			$stmtv = $conn->prepare('delete from routine where class_id = ?');
			$stmtv->bind_param("s", $postedclass_id);
			$stmtv->execute();
		}
	}
	} else{
		$stmtaa = $conn->prepare('delete from student where roll = ?');
		$stmtaa->bind_param("s", $stu_roll);
		$stmtaa->execute();
		$stmtza = $conn->prepare('delete from attendance where roll = ?');
		$stmtza->bind_param("s", $stu_roll);
		$stmtza->execute();
		$stmtax = $conn->prepare('delete from class where id = ?');
		$stmtax->bind_param("s", $postedclass_id);
		$stmtax->execute();
		$stmtvzz = $conn->prepare('delete from routine where class_id = ?');
		$stmtvzz->bind_param("s", $postedclass_id);
		$stmtvzz->execute();
	}

?>