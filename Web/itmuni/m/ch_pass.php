<?php
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
if(!$_POST['old_pass'] or !$_POST['new_pass'] or !$_POST['ver_pass']){echo '<script>window.parent.location = "index.php"</script>';}
$old_pass=$_POST['old_pass'];
$old_pass=htmlspecialchars($old_pass, ENT_QUOTES, 'UTF-8');
$new_pass=$_POST['new_pass'];
$new_pass=htmlspecialchars($new_pass, ENT_QUOTES, 'UTF-8');
$ver_pass=$_POST['ver_pass'];
$ver_pass=htmlspecialchars($ver_pass, ENT_QUOTES, 'UTF-8');
if($new_pass == $ver_pass){
	$stmt = $conn->prepare('SELECT * from login where roll=? and password= ?');
	$stmt->bind_param("ss", $roll, $old_pass);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		$stmt = $conn->prepare('update login set password=? where roll=? and password= ?');
		$stmt->bind_param("sss", $new_pass, $roll, $old_pass);
		$stmt->execute();
		if(!$stmt->execute()){echo $stmt->error;}
		echo "<span style='color:green'>Your password has been changed.</span>";
	} else {echo "<span style='color:red'>Your Old password is incorrect.</span>";}
} else {echo "<span style='color:red'>New Passwords doesn't match.</span>";}
?>