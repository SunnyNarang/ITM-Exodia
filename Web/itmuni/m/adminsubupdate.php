<?php
ob_start();
session_start();
$roll=$_SESSION['roll'];
$type=$_SESSION['type'];
if(!$roll or !$type){echo '<script>window.parent.location = "index.php"</script>';}
include('../db.php');
if(!$_POST['sub_id']){echo '<script>window.parent.location = "index.php"</script>';}
$sub_name=$_POST['sub_name'];
$sub_name=htmlspecialchars($sub_name, ENT_QUOTES, 'UTF-8');
$sub_id=$_POST['sub_id'];
$sub_id=htmlspecialchars($sub_id, ENT_QUOTES, 'UTF-8');
$sub_type=$_POST['sub_type'];
$sub_type=htmlspecialchars($sub_type, ENT_QUOTES, 'UTF-8');
$sub_code=$_POST['sub_code'];
$sub_code=htmlspecialchars($sub_code, ENT_QUOTES, 'UTF-8');
$sub_credits=$_POST['sub_credits'];
$sub_credits=htmlspecialchars($sub_credits, ENT_QUOTES, 'UTF-8');
$sub_teacher_roll=$_POST['sub_teacher_roll'];
$sub_teacher_roll=htmlspecialchars($sub_teacher_roll, ENT_QUOTES, 'UTF-8');

$stmt = $conn->prepare('update subject set name = ?,type = ?,credits = ?,code = ?,teacher_roll = ? where id=?');
      $stmt->bind_param('ssssss', $sub_name, $sub_type, $sub_credits, $sub_code, $sub_teacher_roll, $sub_id);
   if($stmt->execute()){echo "<span style='color:#328c15;margin-top:5px;font-size:18px'>Updated Successfully !</span>";}
?>
