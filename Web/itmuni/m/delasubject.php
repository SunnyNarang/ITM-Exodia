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
			$stmtz = $conn->prepare('delete from subject where id = ?');
			$stmtz->bind_param("s", $postedroll);
			if($stmtz->execute()){
				$stmtzq = $conn->prepare('delete from routine where sub_id = ?');
				$stmtzq->bind_param("s", $postedroll);
				$stmtzq->execute();
				
				$stmtzqq = $conn->prepare('delete from attendance where sub_id = ?');
				$stmtzqq->bind_param("s", $postedroll);
				$stmtzqq->execute();
			}
?>