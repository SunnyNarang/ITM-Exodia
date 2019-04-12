<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
$parent_cat = $_GET['parent_cat'];

$stmt = $conn->prepare('SELECT distinct branch from class where course = ?');
$stmt->bind_param('s', $parent_cat);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
	echo "<option value='$row[branch]'>$row[branch]</option>";
}}
?>