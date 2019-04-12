<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
$postedroll=$_POST['class_id'];
$postedroll=htmlspecialchars($postedroll, ENT_QUOTES, 'UTF-8');
			$stmtz = $conn->prepare('delete from notice where id = ?');
			$stmtz->bind_param("s", $postedroll);
			if($stmtz->execute()){
				echo "Deleted !";
			}
?>