<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){header('Location: index.php');}
include('db.php');

$add_course=$_POST['add_course'];
$add_course=htmlspecialchars($add_course, ENT_QUOTES, 'UTF-8');
$add_branch=$_POST['add_branch'];
$add_branch=htmlspecialchars($add_branch, ENT_QUOTES, 'UTF-8');
$add_sem=$_POST['add_sem'];
$add_sem=htmlspecialchars($add_sem, ENT_QUOTES, 'UTF-8');
$add_name=$_POST['add_name'];
$add_name=htmlspecialchars($add_name, ENT_QUOTES, 'UTF-8');

$stmt = $conn->prepare('SELECT * FROM class where course = ? and branch = ? and sem = ? and name = ?');
$stmt->bind_param('ssss', $add_course, $add_branch, $add_sem, $add_name);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
	echo "<span style='font-size: 16px;color:red'>Sorry, Class already Exists !</span>";
} else {
	$stmt = $conn->prepare('insert into class(course, branch, sem, name) values(?,?,?,?)');
$stmt->bind_param("ssss", $add_course, $add_branch, $add_sem, $add_name);
if($stmt->execute()){echo "<span style='font-size: 16px;color:green'>Class added Successfully !</span>";} else{ echo "There was some error !";}
}
?>