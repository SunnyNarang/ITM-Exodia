<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
if(!$_POST['id']){echo '<script>window.parent.location = "index.php"</script>';}
$postedid=$_POST['id'];
$postedid=htmlspecialchars($postedid, ENT_QUOTES, 'UTF-8');
$stmt = $conn->prepare('delete from temp_students where roll=?');
$stmt->bind_param("s", $postedid);
$stmt->execute();
$stmt12 = $conn->prepare('delete from login where roll=?');
$stmt12->bind_param("s", $postedid);
$stmt12->execute();
?>