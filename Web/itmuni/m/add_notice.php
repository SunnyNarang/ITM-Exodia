<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
$title=$_POST['notice_title'];
$desc=$_POST['notice_description'];
$n_type=$_POST['notice_type'];
$title=htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
$desc=htmlspecialchars($desc, ENT_QUOTES, 'UTF-8');
$n_type=htmlspecialchars($n_type, ENT_QUOTES, 'UTF-8');
if(!$title or !$desc){echo '<script>window.parent.location = "index.php"</script>';}
$nodate=date("Y/m/d");
$stmtq = $conn->prepare('INSERT INTO `notice`(`title`, `body`, `notice_date`, `t_id`, type)  values(?,?,?,?,?)');
			$stmtq->bind_param("sssss", $title, $desc, $nodate, $roll, $n_type);
			if($stmtq->execute()){
				echo '<script>window.parent.location = "index.php"</script>';
				}
?>
