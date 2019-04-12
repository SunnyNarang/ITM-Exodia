<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('db.php');
if(!$_POST['date'] or !$_POST['sub'] or !$_POST['class_id']){echo '<script>window.parent.location = "index.php"</script>';}
$posteddate=$_POST['date'];
$posteddate=htmlspecialchars($posteddate, ENT_QUOTES, 'UTF-8');
$postedtime=$_POST['att_time'];
$postedtime=htmlspecialchars($postedtime, ENT_QUOTES, 'UTF-8');
$postedsub=$_POST['sub'];
$postedsub=htmlspecialchars($postedsub, ENT_QUOTES, 'UTF-8');
$postedclass_id=$_POST['class_id'];
$postedclass_id=htmlspecialchars($postedclass_id, ENT_QUOTES, 'UTF-8');
//start if-else
$stmt = $conn->prepare('DELETE from attendance where class_id=? and sub_id=? and att_date=? and time=? and teacher_roll=?');
$stmt->bind_param("sssss", $postedclass_id, $postedsub, $posteddate, $postedtime, $roll);
$stmt->execute();
echo "Deleted"; ?>