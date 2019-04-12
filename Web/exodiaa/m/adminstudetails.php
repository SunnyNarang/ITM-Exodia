<?php
ob_start();
error_reporting(0);
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
if(!$_POST['name']){echo '<script>window.parent.location = "index.php"</script>';}
$postedroll=$_POST['roll'];
$postedroll=htmlspecialchars($postedroll, ENT_QUOTES, 'UTF-8');
$postedname=$_POST['name'];
$postedname=htmlspecialchars($postedname, ENT_QUOTES, 'UTF-8');
$postedemail=$_POST['email'];
$postedemail=htmlspecialchars($postedemail, ENT_QUOTES, 'UTF-8');
$posteddob=$_POST['dob'];
$posteddob=htmlspecialchars($posteddob, ENT_QUOTES, 'UTF-8');
$postedf_name=$_POST['f_name'];
$postedf_name=htmlspecialchars($postedf_name, ENT_QUOTES, 'UTF-8');
$postedf_mob=$_POST['f_mob'];
$postedf_mob=htmlspecialchars($postedf_mob, ENT_QUOTES, 'UTF-8');
$postedadd1=$_POST['add1'];
$postedadd1=htmlspecialchars($postedadd1, ENT_QUOTES, 'UTF-8');
$postedadd2=$_POST['add2'];
$postedadd2=htmlspecialchars($postedadd2, ENT_QUOTES, 'UTF-8');
$postedcity=$_POST['city'];
$postedcity=htmlspecialchars($postedcity, ENT_QUOTES, 'UTF-8');
$postedphone=$_POST['phone'];
$postedphone=htmlspecialchars($postedphone, ENT_QUOTES, 'UTF-8');
$postedbatch=$_POST['batch'];
$postedbatch=htmlspecialchars($postedbatch, ENT_QUOTES, 'UTF-8');
$stmt = $conn->prepare('update student set name = ?,email = ?,dob = ?,f_name = ?,f_mob = ?,address1 = ?,address2 = ?,city = ?,phone = ?,batch = ? where roll = ?');
        $stmt->bind_param('sssssssssss', $postedname, $postedemail, $posteddob, $postedf_name, $postedf_mob, $postedadd1, $postedadd2, $postedcity, $postedphone, $postedbatch, $postedroll);
        if($stmt->execute()){
			$stmta = $conn->prepare('update login set name = ?,email = ? where roll = ?');
        $stmta->bind_param('sss', $postedname, $postedemail, $postedroll);
        if($stmta->execute()){echo "<span style='color:#328c15;margin-top:5px;font-size:18px'>Updated Successfully !</span>";} else {echo "<span style='color:red;margin-top:5px;font-size:18px'>email or roll already exists !</span>";}
		}  else {echo "<span style='color:red;margin-top:5px;font-size:18px'>email or roll already exists !</span>";}
?>
